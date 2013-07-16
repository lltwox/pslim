<?php
namespace PSlim\StandardException;

use PSlim\StandardException;

/**
 * Exception thrown, when requested class wasn't found
 *
 * @author lltwox <lltwox@gmail.com>
 *
 */
class CouldNotInvokeConstructor extends StandardException {

    /**
     * Standard exception tag
     *
     * @var string
     */
    protected $exceptionTag = 'COULD_NOT_INVOKE_CONSTRUCTOR';

}