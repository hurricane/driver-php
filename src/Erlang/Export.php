<?php

namespace Erlang;

/**
 * Implements an Erlang export.
 */
class Export {
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
     *
     * @return void
     */
    public function __construct($module, $function, $arity) {
        $this->module = $module;
        $this->function = $function;
        $this->arity = $arity;
    }
}