<?php

/**
 * Implementation of the Erlang binary protocol.
 *
 * Provides facilities to work with Standard I/O streams, sockets, and
 * Erlang binary messages.
 */
namespace Hurricane\Erlang;

/**
 * Implements an Erlang port.
 */
class Port
{
    /**
     * @var Atom
     */
    public $atom;

    /**
     * @var integer
     */
    public $identifier;

    /**
     * @var integer
     */
    public $creation;

    /**
     * Set the given data on the object.
     *
     * @param Atom $atom
     * @param integer $identifier
     * @param integer $creation
     */
    public function __construct($atom, $identifier, $creation)
    {
        $this->atom = $atom;
        $this->identifier = $identifier;
        $this->creation = $creation;
    }
}