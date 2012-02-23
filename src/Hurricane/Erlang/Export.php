<?php

/**
 * Implementation of the Erlang binary protocol.
 *
 * Provides facilities to work with Standard I/O streams, sockets, and
 * Erlang binary messages.
 */
namespace Hurricane\Erlang;

/**
 * Implements an Erlang export.
 */
class Export
{
    /**
     * @var Atom
     */
    public $module;

    /**
     * @var Atom
     */
    public $function;

    /**
     * @var integer
     */
    public $arity;

    /**
     * Set the given data on the object.
     *
     * @param Atom $module
     * @param Atom $function
     * @param integer $arity
     */
    public function __construct($module, $function, $arity)
    {
        $this->module = $module;
        $this->function = $function;
        $this->arity = $arity;
    }
}