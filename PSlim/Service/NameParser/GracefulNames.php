<?php
namespace PSlim\Service\NameParser;

use PSlim\Service\NameParser;

/**
 * Name parser, that converts graceful names to camel-cased ones
 *
 * @author lex
 *
 */
class GracefulNames implements NameParser {

    /**
     * Symbol, used to implode parts of paths and classes
     *
     */
    protected $implodeSymbol= '';

    /**
     * Parse name from FitNesse location to php
     *
     * @param string $name
     * @return string
     */
    public function parse($name) {
        $parts = explode(' ', $name);
        $parts = array_map('ucfirst', $parts);

        return implode($this->implodeSymbol, $parts);
    }

    /**
     * Get symbol to implode classname to pathname
     *
     * @return string
     */
    public function getImplodeSymbol() {
        return $this->implodeSymbol;
    }

}