<?php
namespace PSlim\StandardException;

use PSlim\StandardException;

/**
 * Exception thrown, when method in class wansn't found
 *
 * @author lex
 *
 */
class NoMethodInClass extends StandardException {

    /**
     * Standard exception tag
     *
     * @var string
     */
    protected $exceptionTag = 'COULD_NOT_INVOKE_CONSTRUCTOR';

}