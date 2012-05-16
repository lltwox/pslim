<?php
namespace PSlim;

use PSlim\LengthFormat\Decoder;

/**
 * Class, representing list of instructions.
 *
 * @author lex
 *
 */
class InstructionList {

    /**
     * Internal array with instructions
     *
     * @var array
     */
    private $instructions = array();

    /**
     * Constructor
     *
     * @param string $input - input from FitNesse, length encoded
     */
    public function __construct($input) {
        $elements = $this->getArrayOfElements($input);
        foreach ($elements as $element) {
            $this->add(Instruction::create($element));
        }
    }

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
        $responseList = new ResponseList();
        /* @var $instruction Instruction */
        foreach ($this->instructions as $instruction) {
            $response = $instruction->execute();
            $responseList->add($response);
        }

        return $responseList;
    }

    /**
     * Get elements, decoded from list and transformed into arrays
     *
     * @param string $input
     * @return array
     */
    private function getArrayOfElements($input) {
        $decoder = new Decoder();
        return $decoder->decode($input);
    }

}