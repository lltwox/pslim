<?php
namespace PSlim\StandardException;

use PSlim\StandardException;

/**
 * Exception thrown, when instruction cannot be parsed or missing pareters
 *
 * @author lltwox <lltwox@gmail.com>
 *
 */
class MalformedInstruction extends StandardException {

    /**
     * Standard exception tag
     *
     * @var string
     */
    protected $exceptionTag = 'MALFORMED_INSTRUCTION';

}