<?php

/**
 * Implementation of the Erlang binary protocol.
 *
 * Provides facilities to work with Standard I/O streams, sockets, and
 * Erlang binary messages.
 */
namespace Hurricane\Erlang;

/**
 * Implements an Erlang "new reference" (a reference created at runtime).
 */
class NewReference {
    /**
     * @var Atom
     */
    public $atom;

    /**
     * @var integer
     */
    public $creation;

    /**
     * @var array
     */
    public $ids;

    /**
     * Set the given data on the object.
     *
     * @param Atom $atom
     * @param integer $creation
     * @param array $ids
     *
     * @return void
     */
    public function __construct($atom, $creation, $ids) {
        $this->atom = $atom;
        $this->creation = $creation;
        $this->ids = $ids;
    }
}