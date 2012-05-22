<?php
namespace PSlim\Type;

/**
 * Converter for null
 * (null is reserved word, hence the name)
 *
 * @author lex
 *
 */
class Nothing implements Converter {

    /**
     * Convert null to a string
     *
     * @param mixed object
     * @return string
     * @throws Exception
     */
    public function toString($object) {
        if ($object !== null) {
            throw new Exception('Not a null');
        }

        return '/__VOID__/';
    }

    /**
     * Convert a string to null
     *
     * @param string
     * @return mixed
     * @throws Exception
    */
    public function fromString($string) {
        $lowercased = strtolower($string);
        if ($lowercased !== 'null') {
            throw new Exception('Not a null');
        }

        return null;
    }

}