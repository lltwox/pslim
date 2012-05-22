<?php
namespace PSlim\Type;

/**
 * Converter for array or list of elements
 *
 * @author lex
 *
 */
class Collection implements Converter {

    /**
     * Convert an array to a string
     *
     * @param mixed object
     * @return string
     * @throws Exception
     */
    public function toString($object) {
        if (!is_array($object)) {
            throw new Exception('Not an array');
        }

        // elements of the array should also be convertable to string
        foreach ($object as $key => $item) {
            // case of the object, that cannot be converted to string
            if (is_object($item) && !method_exists($item, '__toString')) {
                $object[$key] = 'Object';
            }
        }

        return '[' . implode(', ', $object) . ']';
    }

    /**
     * Convert a string to an array
     *
     * @param string
     * @return mixed
     * @throws Exception
    */
    public function fromString($string) {
        if (mb_substr($string, 0, 1) != '['
            || mb_substr($string, -1) != ']'
        ) {
            throw new Exception('Not an array');
        }

        $arrayStr = mb_substr($string, 1, -1);

        return explode(', ', $arrayStr);
    }

}