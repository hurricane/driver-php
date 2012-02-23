<?php

namespace Hurricane\Erlang\DataType;

/**
 * Implements an Erlang function (defined at compile-time).
 */
class ErlFunction
{
    /**
     * @var Pid
     */
    public $pid;

    /**
     * @var Atom
     */
    public $module;

    /**
     * @var integer
     */
    public $index;

    /**
     * @var integer
     */
    public $uniq;

    /**
     * @var array
     */
    public $free_vars;

    /**
     * Set the given data on the object.
     *
     * @param Pid $pid
     * @param Atom $module
     * @param integer $index
     * @param integer $uniq
     * @param array $free_vars
     */
    public function __construct($pid, $module, $index, $uniq, $free_vars)
    {
        $this->pid = $pid;
        $this->module = $module;
        $this->index = $index;
        $this->uniq = $uniq;
        $this->free_vars = $free_vars;
    }
}