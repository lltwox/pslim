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
     * Get exception message
     *
     * @return string
     */
    public function getMessage() {
        return 'Test didn\'t run due to previous errors';
    }

}