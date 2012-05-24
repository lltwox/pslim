<?php
namespace PSlim;

use PSlim\Service\AliasRegistry;
use PSlim\Service\InstanceStorage;
use PSlim\StandardException\NoInstance;
use PSlim\StandardException\NoMethodInClass;

/**
 * Invocation chain implementation
 *
 * @author lex
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
     * Fixture object
     *
     * @var object
     */
    private $object = null;

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
     * Check if instance exists
     *
     * @return boolean
     */
    private function instanceExists() {
        return
            $this->instanceStorage->hasInstance()
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

}