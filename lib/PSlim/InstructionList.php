<?php
namespace PSlim;

use PSlim\LengthFormat\Decoder;
use PSlim\Instruction;
use PSlim\Response;
use PSlim\StandardException\StopTestException;
use PSlim\StandardException\StopSuiteException;

/**
 * Class, representing list of instructions.
 *
 * @author lltwox <lltwox@gmail.com>
 *
 */
class InstructionList extends ServiceLocatorUser {

    /**
     * Flag, used by instructions list, showing if suite was aborted
     *
     * @boolean
     */
    private static $suiteAborted = false;

    /**
     * Flag, showing if current set of instructions was aborted
     *
     * @var boolean
     */
    private $testAborted = false;

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
        if (self::$suiteAborted) {
            return $this->getSuiteAbortedResponse();
        }

        $responseList = new ResponseList();
        /* @var $instruction Instruction */
        foreach ($this->instructions as $instruction) {
            if ($this->testAborted) {
                break;
            }

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
     * Get response object, that suite has been aborted
     *
     * @return Response\SuiteAbortedException
     */
    private function getSuiteAbortedResponse() {
        if (empty($this->instructions)) {
            return new ResponseList();
        }
        $firstInstruction = array_shift($this->instructions);
        $response = new Response\Error(
            $firstInstruction->getId(), new StopSuiteException()
        );

        return new ResponseList(array($response));
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
        } catch (\Exception $e) {
            if ($this->isStopTestException($e)) {
                $this->testAborted = true;
                if ($this->isStopSuiteException($e)) {
                    self::$suiteAborted = true;
                }

                $e = new StopTestException($e->getMessage());
            }

            $response = new Response\Error($instruction->getId(), $e);
        }

        return $response;
    }

    /**
     * Check if this is a stop test exception
     *
     * @param \Exception $e
     * @return boolean
     */
    private function isStopTestException(\Exception $e) {
        $exceptionClass = get_class($e);

        return
            (strpos($exceptionClass, 'StopTest') !== false)
            || $this->isStopSuiteException($e)
        ;
    }

    /**
     * Check if this is a stop suite exception
     *
     * @param \Exception $e
     * @return boolean
     */
    private function isStopSuiteException(\Exception $e) {
        $exceptionClass = get_class($e);
        return (strpos($exceptionClass, 'StopSuite') !== false);
    }

}