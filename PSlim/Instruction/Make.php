<?php
namespace PSlim\Instruction;

use PSlim\ServiceLocator;
use PSlim\Instruction;
use PSlim\Response\Ok;

class Make extends Instruction {

    /**
     * Name of the instance to store created object with in registry
     *
     * @var string
     */
    private $instance = null;

    /**
     * Name of the class to create
     *
     * @var string
     */
    private $className = null;

    /**
     * List of arguments for constructor of object
     *
     * @var array
     */
    private $args = null;

    /**
     * Constructor
     *
     * @param string $id
     * @param array $params
     */
    public function __construct($id, $params) {
        parent::__construct($id);
        $this->instance = array_shift($params);
        $this->className = $this->parseClassName(array_shift($params));
        $this->args = $params;
    }

    /**
     * Execute command and get response
     *
     * @return Response
     */
    public function execute() {
//         $className = $this->getFullyQualifiedClassName();
//         $instance = $this->createObject($className);
//         $this->storeInstance($instance);

        return new Ok($this->getId());
    }

    /**
     * Parse classname to convert it to currently selected php notation
     *
     * @param string $name
     * @return string
     */
    private function parseClassName($name) {
        $nameParser = ServiceLocator::getNameParser();
        return $nameParser->parse($name);
    }

    /**
     * Get fully qualified class name by prepending all imported paths.
     *
     * @return string
     */
    private function getFulltQualifiedName() {
        if (class_exists($this->className)) {
            return $this->className;
        }

        $pathRegisry = ServiceLocator::getPathRegistry();
        $paths = $pathRegisry->getPaths();
    }

}