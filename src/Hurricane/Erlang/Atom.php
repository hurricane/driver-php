<?php

/**
 * Implementation of the Erlang binary protocol.
 *
 * Provides facilities to work with Standard I/O streams, sockets, and
 * Erlang binary messages.
 */
namespace Hurricane\Erlang;

/**
 * Implements an Erlang atom.
 */
class Atom {
    /**
     * @var string
     */
    public $name;

    /**
     * Set the given data on the object.
     *
     * @param string $name
     *
     * @return void
     */
    public function __construct($name) {
        $this->name = $name;
    }
}