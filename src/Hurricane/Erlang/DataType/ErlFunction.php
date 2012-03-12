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
    private $_pid;

    /**
     * @var Atom
     */
    private $_module;

    /**
     * @var integer
     */
    private $_index;

    /**
     * @var integer
     */
    private $_uniq;

    /**
     * @var array
     */
    private $_free_vars;

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
        $this->setPid($pid);
        $this->setModule($module);
        $this->setIndex($index);
        $this->setUniq($uniq);
        $this->setFreeVars($free_vars);
    }

    /**
     * Setter for free vars.
     *
     * @param array $free_vars
     *
     * @return void
     */
    public function setFreeVars($free_vars)
    {
        $this->_free_vars = $free_vars;
    }

    /**
     * Getter for free vars.
     *
     * @return array
     */
    public function getFreeVars()
    {
        return $this->_free_vars;
    }

    /**
     * Getter for the number of free vars.
     *
     * @return int
     */
    public function getNumFreeVars()
    {
        if (!$this->_free_vars) {
            return 0;
        } else {
            return count($this->_free_vars);
        }
    }

    /**
     * Setter for index.
     *
     * @param int $index
     *
     * @return void
     */
    public function setIndex($index)
    {
        $this->_index = $index;
    }

    /**
     * Getter for index.
     *
     * @return int
     */
    public function getIndex()
    {
        return $this->_index;
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

    /**
     * Setter for pid.
     *
     * @param \Hurricane\Erlang\DataType\Pid $pid
     *
     * @return void
     */
    public function setPid($pid)
    {
        $this->_pid = $pid;
    }

    /**
     * Getter for pid.
     *
     * @return \Hurricane\Erlang\DataType\Pid
     */
    public function getPid()
    {
        return $this->_pid;
    }

    /**
     * Setter for uniq.
     *
     * @param int $uniq
     *
     * @return void
     */
    public function setUniq($uniq)
    {
        $this->_uniq = $uniq;
    }

    /**
     * Getter for uniq.
     *
     * @return int
     */
    public function getUniq()
    {
        return $this->_uniq;
    }
}