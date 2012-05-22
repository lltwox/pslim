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
        $parts = array_map(array($this, 'ucfirst'), $parts);

        return implode($this->implodeSymbol, $parts);
    }

    /**
     * Multibyte ucfirst
     *
     * @param string $string
     * @return string
     */
    private function ucfirst($string) {
        return
            mb_strtoupper(
                mb_substr($string, 0, 1, 'UTF-8'), 'UTF-8'
            ) . mb_substr($string, 1, mb_strlen($string), 'UTF-8')
        ;
    }

}