<?php
namespace PSlim\Service\NameParser;

use PSlim\Service\NameParser;

/**
 * Ns stands for Namespace, which is reserverd php word.
 *
 * Name parser, that converts spefifed separators to backslashes and applyes to
 * evey part graceful names parser. In the end class or path name fits
 * namespace path, e.g: HTML\Upload\ErrorException
 *
 * @author lltwox <lltwox@gmail.com>
 *
 */
class Ns extends Pear {

    /**
     * Symbol, used to implode parts of paths and classes
     *
     */
    protected $implodeSymbol= '\\';

}