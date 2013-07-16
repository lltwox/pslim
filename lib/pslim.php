#!/usr/bin/php
<?php
/**
 * Runner for php slim server
 *
 * @author lltwox <lltwox@gmail.com>
 */
// enabling autoloader, so all pslim classes would be available
require_once __DIR__ . '/PSlim/Autoloader.php';
PSlim\Autoloader::enable();

// running server
PSlim\Server::run();