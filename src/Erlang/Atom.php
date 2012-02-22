<?php

namespace Erlang;

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