<?php
namespace PSlim\Service;

use PSlim\ServiceLocatorUser;
use PSlim\Type;

/**
 *
 * Type converter implementation. Class can convert string to appropriate type
 * and backwards.
 *
 * @author lex
 *
 */
class TypeConverter extends ServiceLocatorUser {

    /**
     * Array of all registered converters
     *
     * @var array
     */
    private $converters = null;

    /**
     * Constructor
     *
     */
    public function __construct() {
        $this->converters = array(
            new Type\Boolean(), new Type\Nothing(), new Type\Collection()
        );
    }

    /**
     * Add converter to the list
     *
     * @param Type\Converter $converter
     */
    public function addConverter(Type\Converter $converter) {
        $this->converters[] = $converter;
    }

    /**
     * Convert object to string
     *
     * @param mixed $object
     * @return string
     */
    public function toString($object) {
        /* @var $converter Type\Converter */
        foreach ($this->converters as $converter) {
            try {
                echo "Trying " . get_class($converter) . ":\n";
                return $converter->toString($object);
            } catch (Type\Exception $e) {
                // just continuing to next converter avalable
            }
        }

        // no converters found, let php try to do something
        return $object;
    }

    /**
     * Try to get something more, than a string
     *
     * @param string $string
     * @return mixed
     */
    public function fromString($string) {
        /* @var $converter Type\Converter */
        foreach ($this->converters as $converter) {
            try {
                return $converter->fromString($string);
            } catch (Type\Exception $e) {
                // just continuing to next converter avalable
            }
        }

        return $string;
    }

}