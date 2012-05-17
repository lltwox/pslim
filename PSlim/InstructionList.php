<?php
namespace PSlim;


use PSlim\LengthFormat\Decoder;
use PSlim\Instruction;
use PSlim\Response;

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
            $response = $this->executeInstruction($instruction);
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

    /**
     * Execute one instruction
     *
     * @param Instruction $instruction
     * @return Response
     */
    private function executeInstruction(Instruction $instruction) {
        try {
            $response = $instruction->execute();
        } catch (StandardException $e) {
            $response = new Response\StandardException(
                $instruction->getId(), $e
            );
        } catch (Exception $e) {
            if ($this->isStopTestException($e)) {
                $response = new Response\StopTestException(
                    $instruction->getId(), $e
                );
            } else {
                $response = new Response\UserException(
                    $instruction->getId(), $e
                );
            }
        }

        return $response;
    }

}