#!/usr/bin/php
<?php
/**
 * Runner for php slim server, intented to be called by FitNesse only
 *
 * @author lltwox <lltwox@gmail.com>
 */

require_once __DIR__ . '/PSlim/Autoloader.php';
PSlim\Autoloader::enable();
PSlim\Server::run();