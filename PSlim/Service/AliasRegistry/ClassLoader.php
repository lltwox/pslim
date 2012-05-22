<?php
namespace PSlim\Service\AliasRegistry;

use PSlim\Exception;

/**
 * Alias loader. Parses files with fixtures and loads specified aliases
 * for classes.
 *
 * @author lex
 *
 */
class ClassLoader {

    /**
     * Pattern to match alias
     *
     */
    const ALIAS_TAG_PATTERN = '/@alias\s(.+)$/m';

    /**
     * Path to load fixtures from
     *
     * @var string
     */
    private $path = null;

    /**
     * Set fixture path
     *
     * @param string $path
     * @throws Exception
     */
    public function setFixturePath($path) {
        if (!is_dir($path)) {
            throw new Exception('Specified fixture-path is not valid');
        }
        $this->path = rtrim($path, '/') . '/';
    }

    /**
     * Load aliases from provided path
     *
     * @return array
     */
    public function load() {
        $result = array();
        if (empty($this->path)) {
            return $result;
        }

        $classes = $this->getClassesInPath();
        foreach ($classes as $class) {
            $alias = $this->getClassAlias($class);
            if (!empty($alias)) {
                $result[$alias] = $class;
            }
        }

        return $result;
    }

    /**
     * Get list of classes, found in fixture path
     *
     * @return array
     */
    private function getClassesInPath() {
        $files = $this->getFiles();

        $existingClasses = get_declared_classes();
        foreach ($files as $file) {
            include_once $file;
        }

        return array_diff(get_declared_classes(), $existingClasses);
    }

    /**
     * Get list of php files in dir
     *
     * @param string $dir - sub directory
     * @return array
     */
    private function getFiles($dir = '') {
        $result = array();

        $contents = scandir($this->path . $dir);
        foreach ($contents as $item) {
            // skipping system entries
            if (substr($item, 0, 1) == '.') {
                continue;
            }
            if (is_dir($this->path . $dir . $item)) {
                $result = array_merge(
                    $result, $this->getFiles($dir . $item . '/')
                );
            } else {
                $pathInfo = pathinfo($this->path . $dir . $item);
                if (strtolower($pathInfo['extension']) == 'php'
                    && is_readable($this->path . $dir . $item)
                ) {
                    $result[] = $dir . $item;
                }
            }
        }

        return $result;
    }

    /**
     * Get alias, found in class
     *
     * @param string $className
     * @return string
     */
    private function getClassAlias($className) {
        $reflectionClass = new \ReflectionClass($className);
        $comment = $reflectionClass->getDocComment();
        if (empty($comment)) {
            return null;
        }

        $matches = array();
        $result = preg_match_all(self::ALIAS_TAG_PATTERN, $comment, $matches);
        if (!$result) {
            return null;
        }
        $lastMatchedAlias = array_pop($matches[1]);

        return $lastMatchedAlias;
    }

}