<?php
namespace PSlim;

use PSlim\StandardException\MalformedInstruction;

use PSlim\StandardException;

/**
 * Class, representing an instruction object, that can be executed
 *
 * @author lltwox <lltwox@gmail.com>
 *
 */
abstract class Instruction extends ServiceLocatorUser {

    /**
     * String from server, that indicates, that slim server can shut down
     *
     */
    const BYE = 'bye';

    /**
     * Id of the instruction
     *
     * @var string
     */
    private $id = null;

    /**
     * Create appropriate instruction object
     *
     * @param array $params - decoded array
     * @param ServiceLocator $serviceLocator - instance of service locator to be
     *        used by instructions
     */
    public static function create(array $params) {
        $id = self::extractParam($params);
        $type = self::extractParam($params);

        $classname = self::getInstructionClassname($type);

        /* @var $instance Instruction */
        $instance = new $classname($id, $params);

        return $instance;
    }

    /**
     * Get a appropriate classname for instruction of given type
     *
     * @param string $type
     * @return string
     */
    private static function getInstructionClassname($type) {
        return 'PSlim\\Instruction\\' . ucfirst($type);
    }

    /**
     * Constructor
     *
     * @param string $id - instruction id
     */
    protected function __construct($id) {
        $this->id = $id;
    }

    /**
     * Get id of the instruction
     *
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Execute command and get response
     *
     * @return Response
     */
    abstract public function execute();

    /**
     * Wrapper for array_shift to handle errors
     *
     * @param array &$input - array will be modified the same if array_shift is
     *        called on it
     */
    protected static function extractParam(array &$input) {
        if (empty($input)) {
            throw new StandardException\MalformedInstruction();
        }

        return array_shift($input);
    }

    /**
     * Parse method arguments by applying symbols values, if needed.
     *
     * @param array $args
     * @return array
     */
    protected function parseMethodArguments(array $args) {
        $result = array();
        $storage = $this->getServiceLocator()->getSymbolStorage();
        $converter = $this->getServiceLocator()->getTypeConverter();
        foreach ($args as $arg) {
            $string = $storage->replaceSymbols($arg);
            $result[] = $converter->fromString($string);
        }

        return $result;
    }

}