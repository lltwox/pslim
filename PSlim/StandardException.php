<?php
namespace PSlim;

use PSlim\Exception;

/**
 * Base class for exceptions, thrown during instruction execution and beeing
 * standard to FitNesse. If thrown, it will be catched by list execution process
 * and outputted to FitNesse, which will have a pre-defined nice output on the
 * test page.
 *
 * @author lex
 *
 */
abstract class StandardException extends Exception {

    /**
     * One of standard exception tags
     *
     * @var string
     */
    protected $exceptionTag = null;

    /**
     * Get exception message
     *
     * @return string
     */
    public function getMessage() {
        return $this->$exceptionTag . ' ' . $this->message;
    }

}