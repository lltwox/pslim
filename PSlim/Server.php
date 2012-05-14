<?php
namespace PSlim;

/**
 * Server class, initializes all resources and connects logic
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
     * Process input arguments of t
     */
    private static function processInputArgs() {

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
        $this->bootstrap($args['boostrap']);
        $this->initSocket($args['port']);

        $this->greet();
        $this->serve();

        $this->closeSocket();
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
            $input = $this->socket->read();
            $command = Command::decode($input);
            if ($command->isBye()) {
                break;
            }
            $response = $command->execute();
            $this->socket->write(Response::encode($response));
        }
    }

    /**
     * Close binded socket
     *
     */
    private function closeSocket() {
        $this->socket->close();
    }

    /**
     * Print slim protocol version
     *
     */
    private function greet() {
        $greet = new Response\Greet();
        $this->socket->write(Response::encode($greet));
    }

}