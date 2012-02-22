<?php

namespace Erlang;

/**
 * Defines an interface that must be implemented for any object that
 * wants to serve as the transport layer for the Gateway.
 */
interface StreamInterface
{
    /**
     * Read bytes number of data and return it.
     *
     * @param $bytes integer
     *
     * @return string
     */
    public function read($num);

    /**
     * Write binary data to the stream.
     *
     * @param $data string
     *
     * @return void
     */
    public function write($data);

    /**
     * Write all buffered data to the output device.
     *
     * @return void
     */
    public function flush();

    /**
     * Close the output device.
     *
     * @return void
     */
    public function close();
}
