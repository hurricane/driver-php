<?php

/**
 * Implementation of the Erlang binary protocol.
 *
 * Provides facilities to work with Standard I/O streams, sockets, and
 * Erlang binary messages.
 */
namespace Hurricane\Erlang;

/**
 * Implements an Erlang atom cache ref.
 */
class AtomCacheRef
{
    /**
     * @var integer
     */
    public $value;

    /**
     * Set the given data on the object.
     *
     * @param integer $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }
}