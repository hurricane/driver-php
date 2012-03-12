<?php

namespace Hurricane\Erlang\DataType;

/**
 * Implements an Erlang export.
 */
class Export
{
    /**
     * @var Atom
     */
    private $_module;

    /**
     * @var Atom
     */
    private $_function;

    /**
     * @var integer
     */
    private $_arity;

    /**
     * Set the given data on the object.
     *
     * @param Atom $module
     * @param Atom $function
     * @param integer $arity
     */
    public function __construct($module, $function, $arity)
    {
        $this->setModule($module);
        $this->setFunction($function);
        $this->setArity($arity);
    }

    /**
     * Setter for arity.
     *
     * @param int $arity
     *
     * @return void
     */
    public function setArity($arity)
    {
        $this->_arity = $arity;
    }

    /**
     * Getter for arity.
     *
     * @return int
     */
    public function getArity()
    {
        return $this->_arity;
    }

    /**
     * Setter for function.
     *
     * @param \Hurricane\Erlang\DataType\Atom $function
     *
     * @return void
     */
    public function setFunction($function)
    {
        $this->_function = $function;
    }

    /**
     * Getter for function.
     *
     * @return \Hurricane\Erlang\DataType\Atom
     */
    public function getFunction()
    {
        return $this->_function;
    }

    /**
     * Setter for module.
     *
     * @param \Hurricane\Erlang\DataType\Atom $module
     *
     * @return void
     */
    public function setModule($module)
    {
        $this->_module = $module;
    }

    /**
     * Getter for module.
     *
     * @return \Hurricane\Erlang\DataType\Atom
     */
    public function getModule()
    {
        return $this->_module;
    }
}