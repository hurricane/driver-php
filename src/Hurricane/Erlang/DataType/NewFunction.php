<?php

namespace Hurricane\Erlang\DataType;

/**
 * Implements an Erlang function (created at run-time, usually with
 * the fun () -> end syntax).
 */
class NewFunction
{
    /**
     * @var integer
     */
    private $_arity;

    /**
     * @var string
     */
    private $_uniq;

    /**
     * @var integer
     */
    private $_index;

    /**
     * @var Atom
     */
    private $_module;

    /**
     * @var integer
     */
    private $_old_index;

    /**
     * @var integer
     */
    private $_old_uniq;

    /**
     * @var Pid
     */
    private $_pid;

    /**
     * @var array
     */
    private $_free_vars;

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
     */
    public function __construct(
        $arity, $uniq, $index, $module, $old_index,
        $old_uniq, $pid, $free_vars
    )
    {
        $this->setArity($arity);
        $this->setUniq($uniq);
        $this->setIndex($index);
        $this->setModule($module);
        $this->setOldIndex($old_index);
        $this->setOldUniq($old_uniq);
        $this->setPid($pid);
        $this->setFreeVars($free_vars);
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
     * Setter for old index.
     *
     * @param int $old_index
     *
     * @return void
     */
    public function setOldIndex($old_index)
    {
        $this->_old_index = $old_index;
    }

    /**
     * Getter for old index.
     *
     * @return int
     */
    public function getOldIndex()
    {
        return $this->_old_index;
    }

    /**
     * Setter for old uniq.
     *
     * @param int $old_uniq
     *
     * @return void
     */
    public function setOldUniq($old_uniq)
    {
        $this->_old_uniq = $old_uniq;
    }

    /**
     * Getter for old uniq.
     *
     * @return int
     */
    public function getOldUniq()
    {
        return $this->_old_uniq;
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
     * @param string $uniq
     *
     * @return void
     */
    public function setUniq($uniq)
    {
        $this->_uniq = $uniq;
    }

    /**
     * Setter for uniq.
     *
     * @return string
     */
    public function getUniq()
    {
        return $this->_uniq;
    }
}