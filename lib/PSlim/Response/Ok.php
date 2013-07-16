<?php
namespace PSlim\Response;

use PSlim\Response;

/**
 * Class, representing an OK message in response to Import or Make instructions
 *
 * @author lltwox <lltwox@gmail.com>
 *
 */
class Ok extends Response {

    /**
     * Get data of the specific type of response
     *
     * @return string
     */
    protected function getResponseData() {
        return 'OK';
    }

}