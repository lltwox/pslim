<?php
namespace PSlim\Service;

use PSlim\ServiceLocatorUser;
use PSlim\StandardException;

/**
 * Symbol storage implementation.
 * A container for all symbol values, that were created by 'callAndAssign'
 * instruction.
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
    public $storage = array();

    /**
     * Store value under a name
     *
     * @param string $key
     * @param object $value
     */
    public function store($name, $value) {
        $this->storage[$name] = $value;
    }

    /**
     * Get value, stored under a name
     *
     * @param string $name
     * @throws NoInstance
     * @return object
     */
    public function get($name) {
        if (!isset($this->storage[$name])) {
            throw new StandardException('No symbol found for name' . $name);
        }

        return $this->storage[$name];
    }

    /**
     * Clear value, stored under a name
     *
     * @param $name string
     */
    public function remove($name) {
        unset($this->storage[$name]);
    }

}