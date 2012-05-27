<?php
namespace PSlim\Service;

use PSlim\Fixture\Actor;

/**
 * Library storage implementation.
 * A container for all library objects.
 *
 * @author lex
 *
 */
class LibraryStorage extends InstanceStorage {

    /**
     * Constructor
     *
     */
    public function __construct() {
        $this->store('actor', new Actor());
    }

    /**
     * Store instance under a name
     *
     * @param string $key
     * @param object $object
     */
    public function store($name, $object) {
        // library objects, that were stored later are more important
        array_unshift($this->storage, $object);
    }

    /**
     * Get all objects, stored in library
     *
     * @return array
     */
    public function getObjects() {
        return $this->storage;
    }

}