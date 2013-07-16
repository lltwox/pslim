<?php
namespace PSlim\StandardException;

use PSlim\StandardException;

/**
 * Exception thrown, when FitNesse requested to call method in non-existing
 * instance
 *
 * @author lltwox <lltwox@gmail.com>
 *
 */
class NoInstance extends StandardException {

    /**
     * Standard exception tag
     *
     * @var string
     */
    protected $exceptionTag = 'NO_INSTANCE';

}