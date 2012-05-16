<?php
namespace PSlim\Instruction;

use PSlim\Instruction;
use PSlim\Response\Value;

class CallAndAssign extends Instruction {

    /**
     * Constructor
     *
     * @param string $id
     * @param array $params
     */
    public function __construct($id, $params) {
        parent::__construct($id);
    }

    /**
     * Execute command and get response
     *
     * @return Response
     */
    public function execute() {
        return new Value($this->getId(), 0);
    }

}