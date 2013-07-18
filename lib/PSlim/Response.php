<?php
namespace PSlim;

/**
 * Basic response object
 *
 * @author lltwox <lltwox@gmail.com>
 *
 */
abstract class Response extends ServiceLocatorUser {

    /**
     * Id of the instruction, this response is for
     *
     * @var string
     */
    private $id = null;

    /**
     * Constructor
     *
     * @param string $id - id of the instruction
     */
    public function __construct($id) {
        $this->id = $id;
    }

    /**
     * Data response data
     *
     * @return array
     */
    public function getData() {
        $data = $this->getResponseData();
        // echo "Response data: " . $data . "\n";
        return array($this->id, $data);
    }

    /**
     * Get data of the specific type of response
     *
     * @return string
     */
    abstract protected function getResponseData();

}