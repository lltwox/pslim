<?php
namespace PSlim\StandardException;

use PSlim\StandardException;

/**
 * Exception, throw, when requested class couln\' be constucted.
 *
 * @author lex
 *
 */
class CouldNotInvokeConstructor extends StandardException {

    /**
     * Standard exception tag
     *
     * @var string
     */
    protected $exceptionTag = 'COULD_NOT_INVOKE_CONSTRUCTOR';

    /**
     * Consturctor
     *
     * @param string $message - name of the class, that coundn't
     *                          been constructed
     */
    public function __construct($message) {
        parent::__construct($message);
    }

}