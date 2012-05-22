<?php
namespace PSlim;

class Log {

    public static function log($message) {
        file_put_contents('/tmp/pslimlog', $message . "\n", FILE_APPEND);
    }
}