<?php
namespace PSlim;

/**
 * Slim server implementation.
 *
 * For details about slim protocol, see
 * http://fitnesse.org/FitNesse.UserGuide.SliM.SlimProtocol
 *
 * Class initializes all resources and connects logic
 *
 * @author lex
 *
 */
class Server {

    /**
     * Version of the slim protocol
     *
     */
    const VERSION = '0.3';

    /**
     * Socket object, used for communication with FitNesse
     *
     * @var Socket
     */
    private $socket = null;

    /**
     * Service locator instance
     *
     * @var ServiceLocator
     */
    private $serviceLocator = null;

    /**
     * Run server
     *
     */
    public function run() {
        try {
            $args = self::processInputArgs();
        } catch (Exception $e) {
            self::printHelp();
        }

        $server = new Server();
        try {
            $server->start($args);
        } catch (Exception $e) {
            echo 'Internal PSlim error: ' . $e->getMessage() . "\n";
            echo 'Stack trace: ' . "\n";
            echo $e->getTraceAsString();
        }
    }

    /**
     * Process input arguments of the command line
     *
     * @return array
     */
    private static function processInputArgs() {
        $result = array(
            'port' => 0,
            'bootstrap' => '',
        );

        $args = $_SERVER['argv'];
        $result['port'] = array_pop($args);

        return $result;
    }

    /**
     * Private construcot to enforce use of run() method
     *
     */
    private function __construct() {

    }

    /**
     * Start server
     *
     * @param array $args
     */
    private function start($args) {
        $this->bootstrap($args['bootstrap']);
        $this->initResources();
        $this->initSocket($args['port']);

        $this->greet();
        $this->serve();
    }

    /**
     * Include specified bootstrap file, if needed
     *
     * @param string $file
     * @throws Exception
     */
    private function bootstrap($file) {
        if (empty($file)) {
            return;
        }
        if (!file_exists($file)) {
            throw new Exception('Bootstrap file ' . $file . 'is not found');
        }

        include $file;
    }

    /**
     * Init server resources
     *
     */
    private function initResources() {
        $this->serviceLocator = new ServiceLocator();
        mb_internal_encoding("UTF-8");
    }

    /**
     * Init socket object
     *
     * @param integer $port
     */
    private function initSocket($port) {
        $this->socket = new Socket();
        $this->socket->bind($port);
    }

    /**
     * Main loop, processing input
     *
     */
    private function serve() {
        while (true) {
            $input = $this->readInstructions();
            if ($input == Instruction::BYE) {
                break;
            }

            $instructionsList = new InstructionList(
                $input, $this->serviceLocator
            );
            $responseList = $instructionsList->execute();

            $response = $responseList->encode();
            $this->writeResponse($response);
        }
    }

    /**
     * Print slim protocol version
     *
     */
    private function greet() {
        $this->socket->write('Slim -- V' . self::VERSION . "\n");
    }

    /**
     * Read list of instructions from FitNesse server.
     *
     * As specified in protocol, every list is preceeded with lendth in bytes.
     * List is seperated from length value with a colon. E.g.:
     *       000035:[000002:000005:hello:000005:world:] , where:
     * length^     ^colon            ^ list of instructions
     *
     */
    private function readInstructions() {
        $length = $this->socket->read(6);
        // skipping colon
        $this->socket->read(1);

        return $this->socket->read($length);
    }

    /**
     * Write response for FitNesse server.
     * Encoded the same way as input commands: <length in bytes>:<string>.
     *
     * @param string $response
     */
    private function writeResponse($response) {
        $responseLength = strlen($response);
        $this->socket->write(sprintf('%06d:%s', $responseLength, $response));
    }

    /**
     * Print help message
     *
     */
    private static function printHelp() {
        echo 'Help';
    }

}