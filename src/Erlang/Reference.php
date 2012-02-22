<?php

namespace Erlang;

/**
 * Implements an Erlang reference.
 */
class Reference {
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
     *
     * @return void
     */
    public function __construct($atom, $identifier, $creation) {
        $this->atom = $atom;
        $this->identifier = $identifier;
        $this->creation = $creation;
    }
}