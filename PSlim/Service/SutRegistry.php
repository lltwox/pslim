<?php
namespace PSlim\Service;

use PSlim\ServiceLocatorUser;

/**
 * Sut registry implementation.
 * A container and loader for 'SystemUnderTest' objects.
 *
 * @author lex
 *
 */
class SutRegistry extends ServiceLocatorUser {

    /**
     * Map of sut properties names
     *
     * @var array
     */
    private $sutProperties = array();

    /**
     * Pattern to match sut property
     *
     */
    const SUT_TAG_PATTERN = '/@SystemUnderTest\s*$/m';

    /**
     * Get sut object for the fixture
     *
     * @param object $object
     * @return object
     */
    public function get($object) {
        if (!is_object($object)) {
            return null;
        }
        $className = get_class($object);

        $propertyName = $this->getSutPropertyName($className);
        if (null == $propertyName) {
            return null;
        }

        return $object->$propertyName;
    }

    /**
     * Get sut property name for the class
     *
     * @param string $className
     */
    private function getSutPropertyName($className) {
        if (!array_key_exists($className, $this->sutProperties)) {
            $this->sutProperties[$className] = $this->loadSut($className);
        }

        return $this->sutProperties[$className];
    }

    /**
     * Load property name of the sut object in class
     *
     * @param string $className
     * @return string
     */
    private function loadSut($className) {
        $reflectionClass = new \ReflectionClass($className);
        $properties = $reflectionClass->getProperties(
            \ReflectionProperty::IS_PUBLIC
        );

        /* @var $property \ReflectionProperty */
        foreach ($properties as $property) {
            $comment = $property->getDocComment();
            if (empty($comment)) {
                continue;
            }

            if (preg_match(self::SUT_TAG_PATTERN, $comment)) {
                return $property->getName();
            }
        }

        return null;
    }

}