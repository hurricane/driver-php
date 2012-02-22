<?php

/**
 * Implementation of the Erlang binary protocol.
 *
 * Provides facilities to work with Standard I/O streams, sockets, and
 * Erlang binary messages.
 */
namespace Hurricane\Erlang;

/**
 * The interface to implement for object that know how to transform
 * themselves into a data structure that the Erlang encoding functions
 * know how to encode.
 */
interface Serializable {
    /**
     * The public function that returns a value to serialize as Erlang
     * terms.
     */
    public function toErlang();
}