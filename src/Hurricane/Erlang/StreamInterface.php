<?php

/**
 * Implementation of the Erlang binary protocol.
 *
 * Provides facilities to work with Standard I/O streams, sockets, and
 * Erlang binary messages.
 */
namespace Hurricane\Erlang;

/**
 * Defines an interface that must be implemented for any object that
 * wants to serve as the transport layer for the Gateway.
 */
interface StreamInterface
{
    /**
     * Read bytes number of data and return it.
     *
     * @abstract
     * @param $num
     * @return string
     */
    public function read($num);

    /**
     * Write binary data to the stream.
     *
     * @abstract
     * @param $data string
     */
    public function write($data);

    /**
     * Write all buffered data to the output device.
     *
     * @abstract
     * @return void
     */
    public function flush();

    /**
     * Close the output device.
     *
     * @abstract
     */
    public function close();
}
