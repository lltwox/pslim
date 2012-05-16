<?php
namespace PSlim;

/**
 * Basic response object
 *
 * @author lex
 *
 */
abstract class Response {

    /**
     * Id of the instruction, this response is for
     *
     * @var string
     */
    private $id = null;

    /**
     * Constructor
     *
     * @param string $id - id of the instruction
     */
    public function __construct($id) {
        $this->id = $id;
    }

    /**
     * Data response data
     *
     * @return array
     */
    public function getData() {
        return array($this->id, $this->getResponseData());
    }

    /**
     * Get data of the specific type of response
     *
     * @return string
     */
    abstract protected function getResponseData();

}