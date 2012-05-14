<?php
/**
 * Runner for php slim server
 *
 * @author lex
 */

set_include_path(
    get_include_path()
    . PATH_SEPARATOR . dirname(__FILE__)
);

// enabling autoloader, so all pslim classes would be available
require_once 'PSlim/Autoloader.php';
PSlim\Autoloader::enable();
// running server
PSlim\Server::run();