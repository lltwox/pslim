<?php
namespace PSlim\Service;

use PSlim\ServiceLocatorUser;
use PSlim\StandardException\NoInstance;

/**
 * Instance storage implementation.
 * A container for all instances, that were created by 'make' instruction.
 *
 * @author lex
 *
 */
class InstanceStorage extends ServiceLocatorUser {

    /**
     * Storage array
     *
     * @var array
     */
    protected $storage = array();

    /**
     * Store instance under a name
     *
     * @param string $key
     * @param object $object
     */
    public function store($name, $object) {
        $this->storage[$name] = $object;
    }

    /**
     * Get instance, stored under a name
     *
     * @param string $name
     * @throws NoInstance
     * @return object
     */
    public function get($name) {
        if (!$this->has($name)) {
            throw new NoInstance($name);
        }

        return $this->storage[$name];
    }

    /**
     * Clear instance, stored under a name
     *
     * @param $name string
     */
    public function remove($name) {
        unset($this->storage[$name]);
    }

    /**
     * Check if instance with provided name exists
     *
     * @param string $name
     * @return boolean
     */
    public function has($name) {
        return isset($this->storage[$name]);
    }

}