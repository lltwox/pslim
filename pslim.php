<?php
/**
 * Runner for php slim server
 *
 * @author lex
 */

// enabling autoloader, so all pslim classes would be available
require_once 'PSlim/Autoloader.php';
PSlim\Autoloader::enable();
// running server
PSlim\Server::run();