<?php
namespace PSlim\StandardException;

use PSlim\StandardException;

/**
 * Exception thrown, when FitNesse requested to call method in non-existing
 * instance
 *
 * @author lex
 *
 */
class NoInstance extends StandardException {

    /**
     * Standard exception tag
     *
     * @var string
     */
    protected $exceptionTag = 'NO_CLASS';

}