<?php

namespace Hurricane\Erlang\DataType;

/**
 * Implements an Erlang pid.
 */
class Pid
{
    /**
     * @var Atom
     */
    private $_atom;

    /**
     * @var integer
     */
    private $_identifier;

    /**
     * @var integer
     */
    private $_serial;

    /**
     * @var integer
     */
    private $_creation;

    /**
     * Set the given data on the object.
     *
     * @param Atom $atom
     * @param integer $identifier
     * @param integer $serial
     * @param integer $creation
     */
    public function __construct($atom, $identifier, $serial, $creation)
    {
        $this->setAtom($atom);
        $this->setIdentifier($identifier);
        $this->setSerial($serial);
        $this->setCreation($creation);
    }

    /**
     * Setter for atom.
     *
     * @param \Hurricane\Erlang\DataType\Atom $atom
     *
     * @return void
     */
    public function setAtom($atom)
    {
        $this->_atom = $atom;
    }

    /**
     * Getter for atom.
     *
     * @return \Hurricane\Erlang\DataType\Atom
     */
    public function getAtom()
    {
        return $this->_atom;
    }

    /**
     * Setter for creation.
     *
     * @param int $creation
     *
     * @return void
     */
    public function setCreation($creation)
    {
        $this->_creation = $creation;
    }

    /**
     * Getter for creation.
     *
     * @return int
     */
    public function getCreation()
    {
        return $this->_creation;
    }

    /**
     * Setter for identifier.
     *
     * @param int $identifier
     *
     * @return void
     */
    public function setIdentifier($identifier)
    {
        $this->_identifier = $identifier;
    }

    /**
     * Getter for identifier.
     *
     * @return int
     */
    public function getIdentifier()
    {
        return $this->_identifier;
    }

    /**
     * Setter for serial.
     *
     * @param int $serial
     *
     * @return void
     */
    public function setSerial($serial)
    {
        $this->_serial = $serial;
    }

    /**
     * Getter for serial.
     *
     * @return int
     */
    public function getSerial()
    {
        return $this->_serial;
    }
}