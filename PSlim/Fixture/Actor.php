<?php
namespace PSlim\Fixture;

use PSlim\ServiceLocatorUser;
use PSlim\Service\InstanceStorage;
use PSlim\StandardException;

/**
 * Actor library object, that cab store table actors
 *
 * @author lex
 *
 */
class Actor extends ServiceLocatorUser {

    /**
     * Name of the instance to get from instance storage
     *
     */
    const FIXTURE_INSTANCE_NAME = 'scriptTableActor';

    /**
     * Link to instance storage object
     *
     * @var InstanceStorage
     */
    private $instanceStorage = null;

    /**
     * List of pushed fixtures
     *
     * @var array
     */
    private $fixtures = array();

    /**
     * Constructor
     *
     */
    public function __construct() {
        $this->instanceStorage
            = $this->getServiceLocator()->getInstanceStorage()
        ;
    }

    /**
     * Get fixture, but keep list unmodified
     *
     */
    public function getFixture() {
        $this->checkNotEmpty();
        return $this->fixtures[count($this->fixtures) - 1];
    }

    /**
     * Push new fixture to the list
     *
     */
    public function pushFixture() {
        $object = $this->instanceStorage->get(self::FIXTURE_INSTANCE_NAME);
        array_push($this->fixtures, $object);
        $this->instanceStorage->remove(self::FIXTURE_INSTANCE_NAME);
    }

    /**
     * Pop fixture from the list
     *
     */
    public function popFixture() {
        $this->checkNotEmpty();
        $object = array_pop($this->fixtures);
        $this->instanceStorage->store(self::FIXTURE_INSTANCE_NAME, $object);
    }

    /**
     * Check that fixture stack is not empty
     *
     * @throws StandardException
     */
    private function checkNotEmpty() {
        if (empty($this->fixtures)) {
            throw new StandardException(
                'No fixtures stored in actor object'
            );
        }
    }

}