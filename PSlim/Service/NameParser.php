<?php
namespace PSlim\Service;

use PSlim\ServiceLocatorUser;

/**
 * Name parser abstract class.
 *
 * Name parser is a class, that can convert name of the path or class name
 * from notation, how it was specified in FitNesse test, to a one of php
 * notations.
 *
 * @author lex
 *
 */
abstract class NameParser extends ServiceLocatorUser {

    /**
     * Symbol, used to implode parts of paths and classes
     *
     * @var string
     */
    protected $implodeSymbol = '';

    /**
     * Parse name from FitNesse location to php
     *
     * @param string $name
     * @return string
     */
    abstract public function parse($name);

    /**
     * Get symbol to implode classname to pathname
     *
     * @return string
     */
    public function getImplodeSymbol() {
        return $this->implodeSymbol;
    }

}