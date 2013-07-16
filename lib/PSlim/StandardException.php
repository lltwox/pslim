<?php
namespace PSlim;

use PSlim\Exception;

/**
 * Base class for exceptions, thrown during instruction execution and beeing
 * standard to FitNesse. If thrown, it will be catched by list execution process
 * and outputted to FitNesse, which will have a pre-defined nice output on the
 * test page.
 *
 * @author lltwox <lltwox@gmail.com>
 *
 */
class StandardException extends Exception {

    /**
     * One of standard exception tags
     *
     * @var string
     */
    protected $exceptionTag = null;

    /**
     * Construct an exception
     *
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($message = null, $code = 0, $previous = null) {
        $message = trim($this->exceptionTag . ' ' . $message);
        parent::__construct($message, $code, $previous);
    }

}