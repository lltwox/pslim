<?php
namespace PSlim\Service;

use PSlim\ServiceLocatorUser;

use PSlim\Service;

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
     * Get list of imported paths
     *
     * @return array
     */
    public function getPaths() {
        return $this->paths;
    }

    /**
     * Clear all imported paths
     *
     */
    public function clearPaths() {
        $this->paths = array();
    }

}