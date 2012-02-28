<?php

/**
 * Implementation of the Erlang binary protocol.
 *
 * Provides facilities to work with Standard I/O streams, sockets, and
 * Erlang binary messages.
 */
namespace Hurricane\Erlang;

/**
 * Wraps socket creation and usage logic. Serves as a Gateway transport.
 */
class SocketWrapper implements StreamInterface
{
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
     */
    public function __construct($host, $port)
    {
        // @todo throw exception when not resource (hurricane not started)
        $this->socket = fsockopen($host, $port);
    }

    /**
     * Close the socket.
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * Read data from the socket.
     *
     * @param integer $num
     * @return string
     */
    public function read($num)
    {
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
     * @return string
     */
    public function write($data)
    {
        return fwrite($this->socket, $data);
    }

    /**
     * Exist for interface completeness.
     */
    public function flush()
    {
        fflush($this->socket);
    }

    /**
     * Close the socket.
     */
    public function close()
    {
        fclose($this->socket);
    }
}

