<?php

namespace Hurricane\Erlang\DataType;

/**
 * Implements an Erlang binary.
 */
class Binary
{
    /**
     * @var string
     */
    private $_data;

    /**
     * Set the given data on the object.
     *
     * @param string $data
     */
    public function __construct($data)
    {
        $this->setData($data);
    }

    /**
     * Getter for data.
     *
     * @return string
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * Setter for data.
     *
     * @param mixed $data
     *
     * @return void
     */
    public function setData($data)
    {
        $this->_data = (string) $data;
    }
}
