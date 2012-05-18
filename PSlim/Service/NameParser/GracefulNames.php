<?php
namespace PSlim\Service\NameParser;

use PSlim\Service\NameParser;

/**
 * Name parser, that converts graceful names to camel-cased ones
 *
 * @author lex
 *
 */
class GracefulNames extends NameParser {

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

}