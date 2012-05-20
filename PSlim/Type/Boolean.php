<?php
namespace PSlim\Type;

/**
 * Converter for boolean type
 *
 * @author lex
 *
 */
class Boolean implements Converter {

    /**
     * Convert a boolean to a string
     *
     * @param mixed object
     * @return string
     * @throws Exception
     */
    public function toString($object) {
        if ($object !== true && $object !== false) {
            throw new Exception('Not a boolean');
        }

        return $object ? 'true' : 'false';
    }

    /**
     * Convert a string to a boolean
     *
     * @param string
     * @return mixed
     * @throws Exception
    */
    public function fromString($string) {
        $lowercased = strtolower($string);
        if ($lowercased !== 'true' && $lowercased !== 'false') {
            throw new Exception('Not a boolean');
        }

        return $lowercased == 'true' ? true : false;
    }

}