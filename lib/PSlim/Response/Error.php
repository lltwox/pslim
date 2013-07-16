<?php
namespace PSlim\Response;

use PSlim\StandardException;

use PSlim\Response;
use PSlim\StandardException\StopTestException;

/**
 * Class, representing an error response about an exception, that was thrown
 * during instruction execution
 *
 * @author lltwox <lltwox@gmail.com>
 *
 */
class Error extends Response {

    /**
     * Standard exception tag
     *
     */
    const EXCEPTION_TAG = '__EXCEPTION__:';

    /**
     * Error, to show
     *
     * @var \Error
     */
    private $exception = null;

    /**
     * Consturctor
     *
     * @param string $id
     * @param Error $e
     */
    public function __construct($id, \Exception $e) {
        parent::__construct($id);
        $this->exception = $e;
    }

    /**
     * Get data of the specific type of response
     *
     * @return string
     */
    protected function getResponseData() {
        $message = self::EXCEPTION_TAG;
        // abort message is needed only in case of stop test or stop
        // suite exceptions
        if ($this->exception instanceof StopTestException) {
            $message .= StopTestException::ABORT_TEST_FLAG;
        }

        // message format is the same for all exceptions
        // standardExceptions will add special tags to message by themselves
        $message .= $this->formatMessage($this->exception->getMessage());

        // stack trace is needed only for user errors
        if (!($this->exception instanceof StandardException)) {
            $message
                .= "\n" . 'Stack trace:'
                . "\n" . $this->exception->getTraceAsString()
            ;
        }

        return $message;
    }

    /**
     * Format message of the exception for FitNesse format
     *
     * @param string $message
     * @return string
     */
    private function formatMessage($message) {
        return 'message:<<' . $message . '>>';
    }

}