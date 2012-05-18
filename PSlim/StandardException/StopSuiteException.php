<?php
namespace PSlim\StandardException;

use PSlim\StandardException\StopTestException;

/**
 * Exception thrown, when whole suite execution should be stopped
 *
 * @author lex
 *
 */
class StopSuiteException extends StopTestException {

    /**
     * Construct an exception
     *
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($message = null, $code = 0, $previous = null) {
        $message = 'Test didn\'t run due to previous errors';
        parent::__construct($message, $code, $previous);
    }

}