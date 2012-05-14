<?php
namespace PSlim;

/**
 * Class, allowing to create, read and write to a socket
 * for communicating with FitNesse
 *
 * @author lex
 *
 */
class Socket {

    /**
     * Timeout in seconds for waiting for data to read
     *
     */
    const TIMEOUT = 5;

    /**
     * Number of bytes to read from input at once
     *
     */
    const CHUNK_SIZE = 64;

    /**
     * Default domain
     *
     */
    const DOMAIN = 'localhost';

    /**
     * Socket resource, created by php functions for
     * listening to port for connections
     *
     * @var resource
     */
    private $listeningSocket = null;

    /**
     * Socket resource, created by php functions for
     * communicating over the port
     *
     * @var integer
     */
    private $communicationSocket = null;

    /**
     * Destructor, closing opened sockets
     *
     */
    public function __destruct() {
        $this->closeSocketResource($this->listeningSocket);
        $this->closeSocketResource($this->communicationSocket);
    }

    /**
     * Bind port and start listening to it
     *
     * @param integer $port
     */
    public function bind($port) {
        $this->startListeningTo($port);
        $this->acceptConnection();
    }

    /**
     * Write data to socket
     *
     * @param string $data
     */
    public function write($data) {
        echo "Write: " . $data . "\n";
        $result = socket_write($this->communicationSocket, $data);
        $this->checkResult($result);
    }

    /**
     * Read specified data from socket
     *
     * @param integer $length - length in bytes to read
     * @return string - read data
     */
    public function read($length) {
        $this->waitForData();
        return $this->readData($length);
    }

    /**
     * Init socket resorce and start listening to port
     *
     * @param integer $port
     */
    private function startListeningTo($port) {
        $this->createListeningSocket();
        $this->bindListeningSocket($port);
        $this->listenSocket();
    }

    /**
     * Accept incoming connection
     *
     * @throws Exception
     */
    private function acceptConnection() {
        // this call is blocking, so until we get connection from outside,
        // nothing will happen
        $this->communicationSocket = socket_accept($this->listeningSocket);
        $this->checkResult($this->communicationSocket);

    }

    /**
     * Init socket resource
     *
     */
    private function createListeningSocket() {
        $this->listeningSocket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        $this->checkResult($this->listeningSocket);
    }

    /**
     * Bind socket to a specified port
     *
     * @param integer $port
     * @throws Exception
     */
    private function bindListeningSocket($port) {
        $result = socket_bind($this->listeningSocket, self::DOMAIN, $port);
        $this->checkResult($result);
    }

    /**
     * Start listening for incoming connections
     *
     * @throws Exception
     */
    private function listenSocket() {
        $result = socket_listen($this->listeningSocket);
        $this->checkResult($result);
    }

    /**
     * Before reading any data, ensuring, we need to ensure, that there are
     * data to read
     *
     */
    private function waitForData() {
        $read = array($this->communicationSocket);
        $write = null;
        $except = null;

        $result = socket_select($read, $write, $except, self::TIMEOUT);
        $this->checkResult($result);

        if ($result == 0) {
            throw new Exception(
                'Failed to read anything from socket, when expected'
            );
        }
    }

    /**
     * Read data from communication socket
     *
     * @param integer $length
     */
    private function readData($length) {
        echo "Read: " . $length . "bytes\n";
        $result = '';
        while ($length > 0) {
            $bytesToRead = self::CHUNK_SIZE < $length
                ? self::CHUNK_SIZE : $length
            ;
            $result .= socket_read($this->communicationSocket, $bytesToRead);
            $length -= self::CHUNK_SIZE;
        }

        echo $result . "\n";

        return $result;
    }

    /**
     * Check the result of the socket operation
     *
     * @param boolean $result
     * @throws Exception
     */
    private function checkResult($result) {
        if ($result === false) {
            throw new Exception(
                'Socket operation failed: ' . $this->getLastError()
            );
        }
    }

    /**
     * Get last error, happened to a socket
     *
     * @return string
     */
    private function getLastError() {
        $errorCode = socket_last_error();
        return socket_strerror($errorCode);
    }

    /**
     * Close opened socket resource
     *
     * @param resource $resource
     */
    private function closeSocketResource($resource) {
        if (empty($resource)) {
            return;
        }

        socket_shutdown($resource);
        socket_close($resource);
    }

}
