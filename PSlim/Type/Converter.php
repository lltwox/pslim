<?php
namespace PSlim\Type;

/**
 * Interface, implementing which will allow slim to convert from and
 * to special types.
 *
 * @author lex
 *
 */
interface Converter {

    /**
     * Convert type to string
     *
     * @param mixed object
     * @return string
     * @throws Exception
     */
    public function toString($object);

    /**
     * Convert string to an object
     *
     * @param string
     * @return mixed
     * @throws Exception
     */
    public function fromString($string);

}