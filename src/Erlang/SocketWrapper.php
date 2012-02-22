<?php

namespace Erlang;

/**
 * Wraps socket creation and usage logic. Serves as a Gateway transport.
 */
class SocketWrapper implements StreamInterface {
    /**
     * The socket over which communication is occurring.
     *
     * @var resource
     */
    private $socket;

    /**
     * Open a socket to the given host and port.
     *
     * @param string $host
     * @param integer $port
     *
     * @return void
     */
    public function __construct($host, $port) {
        $this->socket = fsockopen($host, $port);
    }

    /**
     * Close the socket.
     *
     * @return void
     */
    public function __destruct() {
        $this->close();
    }

    /**
     * Read data from the socket.
     *
     * @param integer $num
     *
     * @return string
     */
    public function read($num) {
        $chunks = array();
        $len_read_so_far = 0;
        while ($len_read_so_far < $num) {
            $chunk = fread($this->socket, $num - $len_read_so_far);
            $len_read_so_far += strlen($chunk);
            $chunks[] = $chunk;
        }
        return implode('', $chunks);
    }

    /**
     * Write data to the socket.
     *
     * @param string $data
     *
     * @return string
     */
    public function write($data) {
        return fwrite($this->socket, $data);
    }

    /**
     * Exist for interface completeness.
     *
     * @return void
     */
    public function flush() {
        fflush($this->socket);
    }

    /**
     * Close the socket.
     *
     * @return void
     */
    public function close() {
        fclose($this->socket);
    }
}

