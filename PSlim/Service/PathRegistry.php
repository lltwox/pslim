<?php
namespace PSlim\Service;

use PSlim\ServiceLocatorUser;

/**
 * Path registry implementation.
 * A container for all imported paths.
 *
 * @author lex
 *
 */
class PathRegistry extends ServiceLocatorUser {

    /**
     * List of imported paths
     *
     * @var array
     */
    private $paths = array();

    /**
     * Add path to registry
     *
     * @param string $path
     */
    public function add($path) {
        $nameParser = $this->getServiceLocator()->getNameParser();
        $parsedPath = $nameParser->parse($path);

        // paths, that were imported later are more important
        array_unshift($this->paths, $parsedPath);
    }

    /**
     * Get list of possible class names, taking into account all imported paths
     *
     * @return array
     */
    public function getClassNamesFor($className) {
        $result = array();
        $nameParser = $this->getServiceLocator()->getNameParser();
        $paths = $this->paths;

        $result[] = $nameParser->parse($className);
        foreach ($paths as $path) {
            $result[]
                = $path . $nameParser->getImplodeSymbol()
                . $nameParser->parse($className)
            ;
        }

        return $result;
    }

    /**
     * Clear all imported paths
     *
     */
    public function clearPaths() {
        $this->paths = array();
    }

}