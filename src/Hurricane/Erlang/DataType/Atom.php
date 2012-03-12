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
    private $_name;

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
     * Getter for name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Setter for name.
     *
     * @param mixed $name
     *
     * @return void
     */
    public function setName($name)
    {
        $this->_name = (string) $name;
    }
}
