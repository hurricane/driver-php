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
    private $_bits;

    /**
     * @var string
     */
    private $_data;

    /**
     * Set the given data on the object.
     *
     * @param integer $bits
     * @param string $data
     */
    public function __construct($bits, $data)
    {
        $this->setBits($bits);
        $this->setData($data);
    }

    /**
     * Setter for bits.
     *
     * @param int $bits
     *
     * @return void
     */
    public function setBits($bits)
    {
        $this->_bits = (int) $bits;
    }

    /**
     * Getter for bits.
     *
     * @return int
     */
    public function getBits()
    {
        return $this->_bits;
    }

    /**
     * Setter for data.
     *
     * @param string $data
     *
     * @return void
     */
    public function setData($data)
    {
        $this->_data = $data;
    }

    /**
     * Getter for data
     *
     * @return string
     */
    public function getData()
    {
        return $this->_data;
    }
}