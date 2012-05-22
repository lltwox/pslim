<?php
namespace PSlim\Service;

use PSlim\ServiceLocatorUser;
use PSlim\Service\AliasRegistry\ClassLoader;

/**
 * Alias registry implementation. Class, containing map of translated
 * class names to original ones.
 *
 * @author lex
 *
 */
class AliasRegistry extends ServiceLocatorUser {

    /**
     * Map of aliases
     *
     * @var array
     */
    private $aliases = null;

    /**
     * Alias loader
     *
     * @var Loader
     */
    private $classLoader = null;

    /**
     * Constructor
     *
     */
    public function __construct() {
        $this->classLoader = new ClassLoader();
    }

    /**
     * Replace class name with correct original name, if class name
     * is an alias
     *
     * @param string $className
     * @return string
     */
    public function replaceClassNameWithAlias($className) {
        $aliases = $this->getAliases();
        if (empty($aliases)) {
            return $className;
        }

        if (isset($aliases[$className])) {
            return $aliases[$className];
        } else {
            return $className;
        }
    }

    /**
     * Get include path
     *
     * @param string $relativePath
     */
    public function setFixturePath($path) {
        $this->classLoader->setFixturePath($path);
    }

    /**
     * Get registered aliases
     *
     */
    private function getAliases() {
        if (null === $this->aliases) {
            $this->aliases = $this->classLoader->load();
        }

        return $this->aliases;
    }

}