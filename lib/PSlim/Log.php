<?php
namespace PSlim;

/**
 * Simple logger class, for now only for testing/debuggig purposes
 *
 * @author lltwox <lltwox@gmail.com>
 */
class Log {

    /**
     * Log message
     *
     * @param string $message
     */
    public static function log($message) {
        file_put_contents('/tmp/pslimlog', $message . "\n", FILE_APPEND);
    }

}