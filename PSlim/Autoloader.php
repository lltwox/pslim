<?php
namespace PSlim;

/**
 * Autoloader for pslim classes
 *
 * @author lex
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
        $path = str_replace('\\', '/', $classname) . '.php';
        // using stream_resolve_include_path to look
        // for files on the include path
        if (!stream_resolve_include_path($path)) {
            return false;
        }

        return include ($path);
    }

}