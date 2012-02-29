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
    protected $name;

    /**
     * Set the given data on the object.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->setName($name);
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}