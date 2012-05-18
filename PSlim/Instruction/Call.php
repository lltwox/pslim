<?php
namespace PSlim\Instruction;

use PSlim\Instruction;
use PSlim\Response\Value;
use PSlim\StandardException;
use PSlim\StandardException\NoMethodInClass;

/**
 * Class for execution of FitNesse call instruction
 *
 * @author lex
 *
 */
class Call extends Instruction {

    /**
     * Result value for null
     *
     */
    const VOID_RESULT = '/__VOID__/';

    /**
     * Name of the instance to call method on
     *
     * @var string
     */
    private $instanceName = null;

    /**
     * Name of the method to call
     *
     * @var string
     */
    private $function = null;

    /**
     * Argumets to invoke method with
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
        $this->function = self::extractFirstParam($params);
        $this->args = $params;
    }

    /**
     * Execute command and get response
     *
     * @return Response
     */
    public function execute() {
        $result = $this->callMethod();

        // TODO: convert value to string
        return new Value($this->getId(), $result);
    }

    /**
     * Call current method
     *
     * @return mixed
     */
    protected final function callMethod() {
        $object = $this->getObject();
        return $this->invokeMethod($object);
    }

    /**
     * Get object for current instance name
     *
     * @return object
     */
    private function getObject() {
        $storage = $this->getServiceLocator()->getInstanceStorage();
        return $storage->get($this->instanceName);
    }

    /**
     * Call method on object
     *
     * @param object $object
     * @return mixed
     */
    private function invokeMethod($object) {
        $reflectionMethod = $this->getReflectionMethod($object);
        try {
            $result = $reflectionMethod->invokeArgs($object, $this->args);
        } catch (\ReflectionException $e) {
            throw new StandardException($e->getMessage());
        }

        if ($result == null) {
            $result = self::VOID_RESULT;
        }

        return $result;
    }

    /**
     * Get reflection method object for current method and object
     *
     * @param object $object
     * @return \ReflectionMethod
     */
    private function getReflectionMethod($object) {
        try {
            $reflectionMethod = new \ReflectionMethod($object, $this->function);
        } catch (\ReflectionException $e) {
            throw new NoMethodInClass(
                $this->function . ' ' . get_class($object)
            );
        }

        return $reflectionMethod;
    }

}