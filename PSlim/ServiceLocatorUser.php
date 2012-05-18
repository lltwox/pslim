<?php
namespace PSlim;

use PSlim\StandardException\StopSuiteException;

/**
 * Base class for all classes, that need service locator object
 *
 * @author lex
 *
 */
abstract class ServiceLocatorUser {

    /**
     * Instance of locator class
     *
     * @var ServiceLocator
     */
    private $serviceLocator = null;

    /**
     * Get service locator instance
     *
     * @return \PSlim\ServiceLocator
     */
    public function getServiceLocator() {
        if (null == $this->serviceLocator) {
            throw new StopSuiteException(
                'PSlim failed: no service locator is available: '
                . get_called_class()
            );
        }

        return $this->serviceLocator;
    }

    /**
     * Set service locator instance
     *
     * @param ServiceLocator $serviceLocator
     */
    public function setServiceLocator(ServiceLocator $serviceLocator) {
        $this->serviceLocator = $serviceLocator;
    }
}