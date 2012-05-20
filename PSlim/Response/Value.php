<?php
namespace PSlim\Response;

use PSlim\Response;

/**
 * Class, representing a repsonse with value
 *
 * @author lex
 *
 */
class Value extends Response {

    /**
     * Value to return
     *
     */
    private $value = null;

    /**
     * Constructor
     *
     * @param string $id - id of the instruction
     * @param string $value - value to return
     */
    public function __construct($id, $value) {
        parent::__construct($id);
        $this->value = $value;
    }

    /**
     * Get data of the specific type of response
     *
     * @return string
     */
    protected function getResponseData() {
        $converter = $this->getServiceLocator()->getTypeConverter();
        return $converter->toString($this->value);
    }

}