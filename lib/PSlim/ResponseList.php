<?php
namespace PSlim;

use PSlim\LengthFormat\Encoder;

/**
 * Class, representing list of responses, that should be sent back
 * to FitNesse server
 *
 * @author lltwox <lltwox@gmail.com>
 *
 */
class ResponseList {

    /**
     * Responses in the list
     *
     * @var array
     */
    private $responses = array();

    /**
     * Constructor
     *
     * @param array $responses - list of responses to init list with
     */
    public function __construct(array $responses = array()) {
        foreach ($responses as $response) {
            $this->add($response);
        }
    }

    /**
     * Add response to the list
     *
     * @param Response $response
     */
    public function add(Response $response) {
        $this->responses[] = $response->getData();
    }

    /**
     * Get repsentation of the responses as a string
     *
     * @return string
     */
    public function __toString() {
        return $this->encode();
    }

    /**
     * Encode list of responses in string length encoding
     *
     * @return string
     */
    private function encode() {
        $encoder = new Encoder();
        return $encoder->encode($this->responses);
    }

}