<?php
namespace PSlim;

use PSlim\LengthFormat\Encoder;

/**
 * Class, representing list of responses, that should be sent back
 * to FitNesse server
 *
 * @author lex
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
     * Add response to the list
     *
     * @param Response $response
     */
    public function add(Response $response) {
        $this->responses[] = $response->getData();
    }

    /**
     * Encode list of responses in string length encoding
     *
     * @return string
     */
    public function encode() {
        $encoder = new Encoder();
        return $encoder->encode($this->responses);
    }

}