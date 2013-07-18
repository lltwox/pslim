<?php
namespace PSlim\Instruction;

use PSlim\Instruction;
use PSlim\ServiceLocator;
use PSlim\Response\Ok;

/**
 * Class, representing `Import` instruction
 *
 * @author lltwox <lltwox@gmail.com>
 *
 */
class Import extends Instruction {

    /**
     * Path to import
     *
     * @var string
     */
    private $path;

    /**
     * Constructor
     *
     * @param string $id
     * @param array $params
     */
    public function __construct($id, array $params) {
        parent::__construct($id);
        $this->path = self::extractParam($params);
    }

    /**
     * Execute command and get response
     *
     * @return Response
     */
    public function execute() {
        $this->getServiceLocator()->getPathRegistry()->add($this->path);
        return new Ok($this->getId());
    }

}