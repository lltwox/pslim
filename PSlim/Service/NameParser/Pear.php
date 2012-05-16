<?php
namespace PSlim\Service\NameParser;

use PSlim\Service\NameParser;

/**
 * Name parser, that converts spefifed separators to unserscores and applyes to
 * evey part graceful names parser. In the end class or path name fits PEAR
 * naming convention, e.g: HTML_Upload_Error
 *
 * @author lex
 *
 */
class Pear extends GracefulNames {

    /**
     * Symbol, used to implode parts of paths and classes
     *
     */
    protected $implodeSymbol= '_';

    /**
     * Separator, expected from original notation
     *
     * @var string
     */
    private $separator = '.';

    /**
     * Set separator value
     *
     * @param string $separator
     */
    public function setSeprator($separator) {
        $this->separator = $separator;
    }

    /**
     * Parse name from FitNesse location to php
     *
     * @param string $name
     * @return string
     */
    public function parse($name) {
        $parts = explode($this->separator, $name);
        foreach ($parts as $key => $part) {
            $parts[$key] = parent::parse($part);
        }

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