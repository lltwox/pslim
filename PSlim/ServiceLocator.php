<?php
namespace PSlim;

use PSlim\Exception;
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
     * One instance of service locator, that can be created.
     *
     * @var ServiceLocator
     */
    private static $instance = null;

    /**
     * Instance of path registry object
     *
     * @var PathRegistry
     */
    private $pathRegistry = null;

    /**
     * Instance of name parser object
     *
     * @var NameParser
     */
    private $nameParser = null;

    /**
     * Init instance of service locator.
     *
     * This ensures, that only one instance of service locator can be created
     * and it will be created by PSlim in the begging.
     */
    public static function initInstance() {
        if (null !== self::$instance) {
            throw new Exception(
                'Only one instance of ServiceLocator can be created'
            );
        }

        self::$instance = new ServiceLocator();
        ServiceLocatorUser::setServiceLocator(self::$instance);
    }

    /**
     * Private constructor to enforce use of initialization method
     *
     */
    private function __construct() {
    }

    /**
     * Get path registry, containing all imported paths
     *
     * @return PathRegistry
     */
    public function getPathRegistry() {
        if (null == $this->pathRegistry) {
            $this->setPathRegistry(new PathRegistry());
        }

        return $this->pathRegistry;
    }

    /**
     * Set path registry object
     *
     * @param PathRegistry $registry
     */
    public function setPathRegistry(PathRegistry $registry) {
        $this->pathRegistry = $registry;
        $this->pathRegistry->setServiceLocator($this);
    }

    /**
     * Get name parser object, that can convert names of path and classes
     * in FitNesse notation to currently selected php notation.
     * By default PEAR notation is selected.
     *
     * @return NameParser
     */
    public function getNameParser() {
        if (null == $this->nameParser) {
            $this->nameParser = new NameParser\Pear();
        }

        return $this->nameParser;
    }

    /**
     * Set name parser object
     *
     * @param NameParser $nameParser
     */
    public function setNameParser(NameParser $nameParser) {
        $this->nameParser = $nameParser;
    }

}