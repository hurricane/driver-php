<?php

namespace Hurricane\Erlang\DataType;

/**
 * Implements an Erlang atom cache ref.
 */
class AtomCacheRef
{
    /**
     * @var integer
     */
    private $_value;

    /**
     * Set the given data on the object.
     *
     * @param integer $value
     */
    public function __construct($value)
    {
        $this->setValue($value);
    }

    /**
     * Getter for value.
     *
     * @return int
     */
    public function getValue()
    {
        return $this->_value;
    }

    /**
     * Setter for value.
     *
     * @param int $value
     *
     * @return void
     */
    public function setValue($value)
    {
        $this->_value = (int) $value;
    }
}
