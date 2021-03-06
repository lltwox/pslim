<?php
namespace PSlim\StandardException;

use PSlim\StandardException;

/**
 * Exception thrown, when method in class wansn't found
 *
 * @author lltwox <lltwox@gmail.com>
 *
 */
class NoMethodInClass extends StandardException {

    /**
     * Standard exception tag
     *
     * @var string
     */
    protected $exceptionTag = 'NO_METHOD_IN_CLASS';

}