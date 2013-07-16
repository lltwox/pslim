<?php
namespace PSlim;

use PSlim\Service\AliasRegistry;
use PSlim\Service\InstanceStorage;
use PSlim\Service\SutRegistry;
use PSlim\Service\LibraryStorage;
use PSlim\StandardException\NoInstance;
use PSlim\StandardException\NoMethodInClass;

/**
 * Invocation chain implementation
 *
 * @author lltwox <lltwox@gmail.com>
 *
 */
class InvocationChain extends ServiceLocatorUser {

    /**
     * Name of the instance to invoke method on
     *
     * @var string
     */
    private $instanceName = null;

    /**
     * Method to invoke
     *
     * @var string
     */
    private $method = null;

    /**
     * List of args to invoke method with
     *
     * @var array
     */
    private $args = null;

    /**
     * Link to instance storage object
     *
     * @var InstanceStorage
     */
    private $instanceStorage = null;

    /**
     * Link to alias registry object
     *
     * @var AliasRegistry
     */
    private $aliasRegistry = null;

    /**
     * Link to sut registty object
     *
     * @var SutRegistry
     */
    private $sutRegistry = null;

    /**
     * Link to library storage object
     *
     * @var LibraryStorage
     */
    private $libraryStorage = null;

    /**
     * Fixture object
     *
     * @var object
     */
    private $object = null;

    /**
     * Invocation result
     *
     * @var mixed
     */
    private $invocationResult = null;

    /**
     * Constructor
     *
     * @param string $instanceName
     * @param string $method
     * @param array $args
     */
    public function __construct($instanceName, $method, array $args) {
        $this->instanceName = $instanceName;
        $this->method = $method;
        $this->args = $args;

        $serviceLocator = $this->getServiceLocator();
        $this->instanceStorage = $serviceLocator->getInstanceStorage();
        $this->aliasRegistry = $serviceLocator->getAliasRegistry();
        $this->sutRegistry = $serviceLocator->getSutRegistry();
        $this->libraryStorage = $serviceLocator->getLibraryStorage();
    }

    /**
     * Try to invoke a method
     *
     * @return mixed - result of invocation
     * @throws NoInstance - in case no instance is found and library objects
     *                      didn't help
     * @throws NoMethodInClass - in case no method is found anywhere
     */
    public function invoke() {
        if ($this->instanceExists()) {
            $result = $this->invokeOnFixture();
            if ($result) {
                return $this->getInvocationResult();
            }

            $result = $this->invokeOnSut();
            if ($result) {
                return $this->getInvocationResult();
            }
        }

        $result = $this->invokeOnLibrary();
        if ($result) {
            return $this->getInvocationResult();
        }

        $this->throwException();
    }

    /**
     * Try to invoke method in fixture object
     *
     * @return boolean
     */
    private function invokeOnFixture() {
        $object = $this->getObject();
        $method = $this->aliasRegistry->replaceMethodNameWithAlias(
            get_class($object), $this->method
        );

        return $this->invokeMethodOnObject($method, $object);
    }

    /**
     * Try to invokce method in system under test object
     *
     * @return boolean
     */
    private function invokeOnSut() {
        $sut = $this->sutRegistry->get($this->getObject());
        if (null == $sut || !is_object($sut)) {
            return false;
        }

        return $this->invokeMethodOnObject($this->method, $sut);
    }

    /**
     * Try to invoke on every library object
     *
     * @return boolean
     */
    private function invokeOnLibrary() {
        $objects = $this->libraryStorage->getObjects();
        foreach ($objects as $object) {
            $method = $this->aliasRegistry->replaceMethodNameWithAlias(
                get_class($object), $this->method
            );
            $result = $this->invokeMethodOnObject($method, $object);
            if ($result) {
                return true;
            }
        }

        return false;
    }

    /**
     * Throw an error exception
     *
     */
    private function throwException() {
        if (!$this->instanceStorage->has($this->instanceName)) {
            throw new NoInstance($this->instanceName);
        }

        if (!is_object($this->getObject())) {
            throw new NoMethodInClass($this->method . ' ' . $this->getObject());
        }

        throw new NoMethodInClass(
            $this->method . ' ' . get_class($this->getObject())
        );
    }

    /**
     * Get result of invocation, filled by one of invokeOn* methods
     *
     * @return mixed
     */
    private function getInvocationResult() {
        return $this->invocationResult;
    }

    /**
     * Check if instance exists
     *
     * @return boolean
     */
    private function instanceExists() {
        return
            $this->instanceStorage->has($this->instanceName)
            && is_object($this->getObject())
        ;
    }

    /**
     * Get fixture object
     *
     * @return object
     */
    private function getObject() {
        if (null == $this->object) {
            $this->object = $this->instanceStorage->get($this->instanceName);
        }

        return $this->object;
    }

    /**
     * Invoke method on given object and save result
     *
     * @param string $method
     * @param object $object
     * @return boolean
     */
    private function invokeMethodOnObject($method, $object) {
        $callback = array($object, $method);
        if (!is_callable($callback)) {
            return false;
        }
        $this->invocationResult = call_user_func_array($callback, $this->args);

        return true;
    }

}