<?php

/**
 * Implementation of the Erlang binary protocol.
 *
 * Provides facilities to work with Standard I/O streams, sockets, and
 * Erlang binary messages.
 */
namespace Hurricane\Erlang;

/**
 * Implements an Erlang binary.
 */
class Binary
{
    /**
     * @var string
     */
    public $data;

    /**
     * Set the given data on the object.
     *
     * @param string $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
}