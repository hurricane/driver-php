<?php

namespace Hurricane\Erlang\DataType;

/**
 * Implements an Erlang atom.
 */
class Atom
{
    /**
     * @var string
     */
    public $name;

    /**
     * Set the given data on the object.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }
}