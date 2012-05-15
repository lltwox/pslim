<?php
namespace PSlim\Instruction;

use PSlim\Instruction;

/**
 * Class, representing list of instructions.
 *
 * List of instructions share a common import list and common symbols.
 *
 * @author lex
 *
 */
class Collection {

    /**
     * Internal array with instructions
     *
     * @var array
     */
    private $instructions = array();

    /**
     * Add instruction to collection
     *
     * @param Instruction $instrction
     */
    public function add(Instruction $instruction) {
        $this->instructions[$instruction->getId()] = $instruction;
    }

    /**
     * Execute all instructions in collection
     *
     */
    public function execute() {

    }

}