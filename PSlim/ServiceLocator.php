<?php
namespace PSlim;

use PSlim\Service\PathRegistry;
use PSlim\Service\NameParser;

/**
 * Service locator pattern implementation.
 * Registry of service instances.
 *
 * @author lex
 *
 */
class ServiceLocator {

    /**
     * Instance of path registry object
     *
     * @var PathRegistry
     */
    private static $pathRegistry = null;

    /**
     * Instance of name parser object
     *
     * @var NameParser
     */
    private static $nameParser = null;

    /**
     * Get path registry, containing all imported paths
     *
     * @return \PSlim\Service\PathRegistry
     */
    public static function getPathRegistry() {
        if (null == self::$pathRegistry) {
            self::$pathRegistry = new PathRegistry();
        }

        return self::$pathRegistry;
    }

    /**
     * Set path registry object
     *
     * @param PathRegistry $registry
     */
    public static function setPathRegistry(PathRegistry $registry) {
        self::$pathRegistry = $registry;
    }

    /**
     * Get name parser object, that can convert names of path and classes
     * in FitNesse notation to currently selected php notation.
     * By default PEAR notation is selected.
     *
     * @return \PSlim\Service\NameParser
     */
    public static function getNameParser() {
        if (null == self::$nameParser) {
            self::$nameParser = new NameParser\Pear();
        }

        return self::$nameParser;
    }

    /**
     * Set name parser object
     *
     * @param NameParser $nameParser
     */
    public static function setNameParser(NameParser $nameParser) {
        self::$nameParser = $nameParser;
    }

}