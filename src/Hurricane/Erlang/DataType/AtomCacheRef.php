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
    protected $value;

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
     * @param integer $value
     */
    public function setValue($value)
    {
        $this->value = (int) $value;
    }

    /**
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }
}