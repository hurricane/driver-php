<?php

namespace Hurricane\Erlang\DataType;

/**
 * Implements an Erlang bit binary.
 */
class BitBinary
{
    /**
     * @var integer
     */
    public $bits;

    /**
     * @var string
     */
    public $data;

    /**
     * Set the given data on the object.
     *
     * @param integer $bits
     * @param string $data
     */
    public function __construct($bits, $data)
    {
        $this->bits = $bits;
        $this->data = $data;
    }
}