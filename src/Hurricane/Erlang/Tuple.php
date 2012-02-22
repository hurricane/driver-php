<?php

/**
 * Implementation of the Erlang binary protocol.
 *
 * Provides facilities to work with Standard I/O streams, sockets, and
 * Erlang binary messages.
 */
namespace Hurricane\Erlang;

/**
 * Implements a tuple object to be used with Erlang messaging.
 */
class Tuple {
    /**
     * @var array
     */
    public $data;

    /**
     * Set the given data on the object.
     *
     * @param array $data
     *
     * @return void
     */
    public function __construct($data) {
        $this->data = $data;
    }
}