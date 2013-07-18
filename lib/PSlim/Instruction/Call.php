<?php
namespace PSlim\Instruction;

use PSlim\InvocationChain;

use PSlim\Instruction;
use PSlim\Response\Value;
use PSlim\StandardException;
use PSlim\StandardException\NoMethodInClass;

/**
 * Class for execution of FitNesse call instruction
 *
 * @author lltwox <lltwox@gmail.com>
 *
 */
class Call extends Instruction {

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
    private $method = null;

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

        $this->instanceName = self::extractParam($params);
        $this->method = self::extractParam($params);
        $this->args = $params;
    }

    /**
     * Execute command and get response
     *
     * @return Response
     */
    public function execute() {
        $result = $this->callMethod();
        return new Value($this->getId(), $result);
    }

    /**
     * Call specified method
     *
     * @return mixed
     */
    protected function callMethod() {
        $chain = new InvocationChain(
            $this->instanceName, $this->method,
            $this->parseMethodArguments($this->args)
        );

        return $chain->invoke();
    }

}