<?php
namespace PSlim;

/**
 * Class, representing an instruction object, that can be executed
 *
 * @author lex
 *
 */
abstract class Instruction {

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
     */
    public static function create(array $params) {
        $id = array_shift($params);
        $type = array_shift($params);

        $classname = self::getInstructionClassname($type);

        return new $classname($id, $params);
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

}