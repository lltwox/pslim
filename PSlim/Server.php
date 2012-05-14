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
            echo $e->getMessage();
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
            $input = $this->readCommand();
//             echo $input . "\n";
//             $command = Command::decode($input);
//             if ($command->isBye()) {
//                 break;
//             }
//             $response = $command->execute();
//             $this->writeResponse($response);
        }
    }

    /**
     * Print slim protocol version
     *
     */
    private function greet() {
//         $greet = new Response\Greet();
        // greeting is sent without length encoding
//         $this->socket->write($greet);
        $this->socket->write('Slim -- V0.3' . "\n");
    }

    /**
     * Read command from FitNesse server.
     * As specified in protocol, every command is preceeded with lendth value
     * in bytes of a command, that follows. Command is seperated from length
     * with a colon. E.g.:
     *       000035:[000002:000005:hello:000005:world:] , where:
     * length^     ^colon            ^ command
     *
     */
    private function readCommand() {
        $commandLength = $this->socket->read(6);
        // skipping colon
        $this->socket->read(1);
        return $this->socket->read($commandLength);
    }

}