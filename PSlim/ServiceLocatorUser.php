<?php
namespace PSlim;

use PSlim\Exception;

/**
 * Base class for different helper services classes, provides access
 * to service locator instance
 *
 * @author lex
 *
 */
abstract class ServiceLocatorUser {

    /**
     * Instance of locator class, one for all
     *
     * @var ServiceLocator
     */
    private static $serviceLocator = null;

    /**
     * Set service locator instance
     *
     * @param ServiceLocator $serviceLocator
     */
    public static function setServiceLocator(ServiceLocator $serviceLocator) {
        self::$serviceLocator = $serviceLocator;
    }

    /**
     * Get service locator instance
     *
     * @return \PSlim\ServiceLocator
     */
    protected function getServiceLocator() {
        if (null == self::$serviceLocator) {
            throw new Exception(
                'No service locator is available in class ' . get_called_class()
            );
        }

        return self::$serviceLocator;
    }

}