<?php

namespace Erlang;

/**
 * Implements an Erlang function (created at run-time, usually with
 * the fun () -> end syntax).
 */
class NewFunction {
    /**
     * @var integer
     */
    public $arity;

    /**
     * @var string
     */
    public $uniq;

    /**
     * @var integer
     */
    public $index;

    /**
     * @var Atom
     */
    public $module;

    /**
     * @var integer
     */
    public $old_index;

    /**
     * @var integer
     */
    public $old_uniq;

    /**
     * @var Pid
     */
    public $pid;

    /**
     * @var array
     */
    public $free_vars;

    /**
     * Set the given data on the object.
     *
     * @param integer $arity
     * @param string $uniq
     * @param integer $index
     * @param Atom $module
     * @param integer $old_index
     * @param integer $old_uniq
     * @param Pid $pid
     * @param array $free_vars
     *
     * @return void
     */
    public function __construct(
        $arity, $uniq, $index, $module, $old_index,
        $old_uniq, $pid, $free_vars
    ) {
        $this->arity = $arity;
        $this->uniq = $uniq;
        $this->index = $index;
        $this->module = $module;
        $this->old_index = $old_index;
        $this->old_uniq = $old_uniq;
        $this->pid = $pid;
        $this->free_vars = $free_vars;
    }
}