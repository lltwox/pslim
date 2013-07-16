<?php
namespace PSlim;

/**
 * Autoloader for pslim classes
 *
 * @author lltwox <lltwox@gmail.com>
 *
 */
class Autoloader {

    /**
     * Enable autoloader
     *
     */
    public static function enable() {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Simple autoloading for namespace-based files
     *
     * @param string $classname
     */
    public static function autoload($classname) {
        $path = realpath(
            __DIR__ . '/../' . str_replace('\\', '/', $classname) . '.php'
        );

        if (!file_exists($path)) {
            return false;
        }

        return include ($path);
    }

}