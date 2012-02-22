<?php

/**
 * Implementation of the Erlang binary protocol.
 *
 * Provides facilities to work with Standard I/O streams, sockets, and
 * Erlang binary messages.
 */
namespace Hurricane\Erlang;

/**
 * Implements an Erlang pid.
 */
class Pid {
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
    public $serial;

    /**
     * @var integer
     */
    public $creation;

    /**
     * Set the given data on the object.
     *
     * @param Atom $atom
     * @param integer $identifier
     * @param integer $serial
     * @param integer $creation
     *
     * @return void
     */
    public function __construct($atom, $identifier, $serial, $creation) {
        $this->atom = $atom;
        $this->identifier = $identifier;
        $this->serial = $serial;
        $this->creation = $creation;
    }
}