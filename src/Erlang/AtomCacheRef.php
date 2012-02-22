<?php

/**
 * Implementation of the Erlang binary protocol.
 *
 * Provides facilities to work with Standard I/O streams, sockets, and
 * Erlang binary messages.
 */
namespace Erlang;

/**
 * Implements an Erlang atom cache ref.
 */
class AtomCacheRef {
    /**
     * @var integer
     */
    public $value;

    /**
     * Set the given data on the object.
     *
     * @param integer $value
     *
     * @return void
     */
    public function __construct($value) {
        $this->value = $value;
    }
}