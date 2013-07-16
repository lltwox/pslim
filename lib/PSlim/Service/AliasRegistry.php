<?php
namespace PSlim\Service;

use PSlim\ServiceLocatorUser;
use PSlim\Service\AliasRegistry\ClassLoader;
use PSlim\Service\AliasRegistry\MethodLoader;

/**
 * Alias registry implementation. Class, containing map of translated
 * class names to original ones.
 *
 * @author lltwox <lltwox@gmail.com>
 *
 */
class AliasRegistry extends ServiceLocatorUser {

    /**
     * Map of class aliases
     *
     * @var array
     */
    private $classAliases = null;

    /**
     * Map of method aliases, grouped by class
     *
     * @var array
     */
    private $methodAliases = null;

    /**
     * Class alias loader
     *
     * @var ClassLoader
     */
    private $classLoader = null;

    /**
     * Method alias loader
     *
     * @var MethodLoader
     */
    private $methodLoader = null;

    /**
     * Constructor
     *
     */
    public function __construct() {
        $this->classLoader = new ClassLoader();
        $this->methodLoader = new MethodLoader();
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
     * Replace class name with correct original name, if class name
     * is an alias
     *
     * @param string $className
     * @return string
     */
    public function replaceClassNameWithAlias($className) {
        $aliases = $this->getClassAliases();
        if (empty($aliases)
            || !isset($aliases[$className])
        ) {
            return $className;
        }

        return $aliases[$className];
    }

    /**
     * Replace method name with alias, if alias exists
     *
     * @param string $className
     * @param string $methodName
     * @return string
     */
    public function replaceMethodNameWithAlias($className, $methodName) {
        $aliases = $this->getMethodAliases($className);
        if (empty($aliases) || !isset($aliases[$methodName])) {
            return $methodName;
        }

        return $aliases[$methodName];
    }

    /**
     * Get registered aliases
     *
     */
    private function getClassAliases() {
        if (null === $this->classAliases) {
            $this->classAliases = $this->classLoader->load();
        }

        return $this->classAliases;
    }

    /**
     * Get list of aliases for methods in given class
     *
     * @param string $className
     * @return array
     */
    private function getMethodAliases($className) {
        if (!isset($this->methodAliases[$className])) {
            $this->methodAliases[$className]
                = $this->methodLoader->load($className)
            ;
        }

        return $this->methodAliases[$className];
    }

}