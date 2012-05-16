<?php
namespace PSlim\Service;

/**
 * Name parser interface.
 *
 * Name parser is a class, that can convert name of the path or class name
 * from notation, how it was specified in FitNesse test, to a one of php
 * notations.
 *
 * @author lex
 *
 */
interface NameParser {

    /**
     * Parse name from FitNesse location to php
     *
     * @param string $name
     * @return string
     */
    public function parse($name);

    /**
     * Get symbol to implode classname to pathname
     *
     * @return string
     */
    public function getImplodeSymbol();

}