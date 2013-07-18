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
 * @author lltwox <lltwox@gmail.com>
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

        $this->instanceName = self::extractParam($params);
        $this->className = self::extractParam($params);
        $this->args = $params;
    }

    /**
     * Execute command and get response
     *
     * @return Response
     */
    public function execute() {
        $this->removeStoredInstance();
        $this->addInstance();

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
        if ($this->isLibraryInstance()) {
            $storage = $this->getServiceLocator()->getLibraryStorage();
        } else {
            $storage = $this->getServiceLocator()->getInstanceStorage();
        }
        $storage->remove($this->instanceName);
    }

    /**
     * Add instance to appropriate storage.
     *
     */
    private function addInstance() {
        $symbolStorage = $this->getServiceLocator()->getSymbolStorage();
        if ($symbolStorage->isSymbol($this->className)) {
            $this->storeObject($symbolStorage->get($this->className));
        } else {
            $translatedClassName = $symbolStorage->replaceSymbols(
                $this->className
            );
            $fullClassName = $this->getFullyQualifiedClassName(
                $translatedClassName
            );
            $object = $this->createObject($fullClassName);
            $this->storeObject($object);
        }
    }

    /**
     * Get fully qualified class name by prepending all imported paths.
     *
     * @param string $className
     * @return string
     */
    private function getFullyQualifiedClassName($className) {
        $pathRegisry = $this->getServiceLocator()->getPathRegistry();
        $fullClassNames = $pathRegisry->getClassNamesFor($className);

        foreach ($fullClassNames as $fullClassName) {
            if (class_exists($fullClassName)) {
                return $fullClassName;
            }
        }

        throw new NoClass($className);
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
            $instance = $reflectionClass->newInstanceArgs(
                $this->parseMethodArguments($this->args)
            );
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
        if ($this->isLibraryInstance()) {
            $storage = $this->getServiceLocator()->getLibraryStorage();
        } else {
            $storage = $this->getServiceLocator()->getInstanceStorage();
        }
        $storage->store($this->instanceName, $object);
    }

    /**
     * Check if object should be stored in library instance
     *
     * @return boolean
     */
    private function isLibraryInstance() {
        return
            mb_substr($this->instanceName, 0, mb_strlen('library'))
            == 'library'
        ;
    }

}