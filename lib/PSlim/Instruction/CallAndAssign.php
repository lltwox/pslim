<?php
namespace PSlim\Instruction;

use PSlim\Instruction;
use PSlim\Response\Value;

/**
 * Class for execution of FitNesse callAndAssign instruction
 *
 * @author lltwox <lltwox@gmail.com>
 *
 */
class CallAndAssign extends Call {

    /**
     * Symbol name to store a value under
     *
     * @var string
     */
    private $symbolName = null;

    /**
     * Constructor
     *
     * @param string $id
     * @param array $params
     */
    public function __construct($id, $params) {
        $this->symbolName = self::extractParam($params);
        parent::__construct($id, $params);
    }

    /**
     * Execute command and get response
     *
     * @return Response
     */
    public function execute() {
        $result = $this->callMethod();
        $this->storeSymbolValue($result);

        return new Value($this->getId(), $result);
    }

    /**
     * Store symbol value
     *
     * @param string $value
     */
    private function storeSymbolValue($value) {
        $storage = $this->getServiceLocator()->getSymbolStorage();
        $storage->store('$' . $this->symbolName, $value);
    }

}