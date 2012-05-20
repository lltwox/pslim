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