<?php
namespace PSlim\Instruction;

use PSlim\Instruction;
use PSlim\Response\Ok;
use PSlim\Response\Error;
use PSlim\StandardException\NoClass;
use PSlim\StandardException\CouldNotInvokeConstructor;

/**
 * Class for execution of FitNesse make instruction
 *
 * @author lex
 *
 */
class Make extends Instruction {

    /**
     * Name of the instance to store created object with in registry
     *
     * @var string
     */
    private $instanceName = null;

    /**
     * Name of the class to create
     *
     * @var string
     */
    private $className = null;

    /**
     * List of arguments for constructor of object
     *
     * @var array
     */
    private $args = null;

    /**
     * Constructor
     *
     * @param string $id
     * @param array $params
     */
    public function __construct($id, $params) {
        parent::__construct($id);

        $this->instanceName = self::extractFirstParam($params);
        $this->className = self::extractFirstParam($params);
        $this->args = $params;
    }

    /**
     * Execute command and get response
     *
     * @return Response
     */
    public function execute() {
        $this->removeStoredInstance();

        $className = $this->getFullyQualifiedClassName();
        $object = $this->createObject($className);
        $this->storeObject($object);

        return new Ok($this->getId());
    }

    /**
     * Try to delete instance with current name from instance storage.
     *
     * FitNesse is not very creative about making instance's names, so
     * if one class is not created, all methods may be called on class from
     * previous table.
     */
    private function removeStoredInstance() {
        $storage = $this->getServiceLocator()->getInstanceStorage();
        $storage->remove($this->instanceName);
    }

    /**
     * Get fully qualified class name by prepending all imported paths.
     *
     * @return string
     */
    private function getFullyQualifiedClassName() {
        $pathRegisry = $this->getServiceLocator()->getPathRegistry();
        $classNames = $pathRegisry->getClassNamesFor($this->className);

        foreach ($classNames as $className) {
            if (class_exists($className)) {
                return $className;
            }
        }

        throw new NoClass($this->className);
    }

    /**
     * Create object for given class, using instruction's params
     *
     * @param string $className
     * @return object
     */
    private function createObject($className) {
        $reflectionClass = new \ReflectionClass($className);
        try {
            $instance = $reflectionClass->newInstanceArgs($this->args);
        } catch (\ReflectionException $e) {
            throw new CouldNotInvokeConstructor($this->className);
        }

        return $instance;
    }

    /**
     * Store created object under instance name in registry
     *
     * @param object $instance
     */
    private function storeObject($object) {
        $storage = $this->getServiceLocator()->getInstanceStorage();
        $storage->store($this->instanceName, $object);
    }

}