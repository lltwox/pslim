<?php
namespace PSlim\Response;

use PSlim\Response;

/**
 * Class, representing an OK message in response to Import or Make instructions
 *
 * @author lex
 *
 */
class Error extends Response {

    /**
     * Get data of the specific type of response
     *
     * @return string
     */
    protected function getResponseData() {
        return '__EXCEPTION__:ABORT_SLIM_TEST:message:<<just for fun>>';
    }

}