<?php

namespace Hurricane\Erlang\DataType;

/**
 * Implements an Erlang "new reference" (a reference created at runtime).
 */
class NewReference
{
    /**
     * @var Atom
     */
    private $_atom;

    /**
     * @var integer
     */
    private $_creation;

    /**
     * @var array
     */
    private $_ids;

    /**
     * Set the given data on the object.
     *
     * @param Atom $atom
     * @param integer $creation
     * @param array $ids
     */
    public function __construct($atom, $creation, $ids)
    {
        $this->_atom = $atom;
        $this->_creation = $creation;
        $this->_ids = $ids;
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
     * Setter for ids.
     *
     * @param array $ids
     *
     * @return void
     */
    public function setIds($ids)
    {
        $this->_ids = $ids;
    }

    /**
     * Getter for ids.
     *
     * @return array
     */
    public function getIds()
    {
        return $this->_ids;
    }
}