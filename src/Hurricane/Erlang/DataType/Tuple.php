<?php

namespace Hurricane\Erlang\DataType;

/**
 * Implements a tuple object to be used with Erlang messaging.
 */
class Tuple
{
    /**
     * @var array
     */
    private $_data;

    /**
     * Set the given data on the object.
     *
     * @param array $data
     */
    public function __construct($data)
    {
        $this->setData($data);
    }

    /**
     * Append an element to this tuple.
     *
     * @param $element
     *
     * @return \Hurricane\Erlang\DataType\Tuple
     */
    public function append($element)
    {
        $this->_data[] = $element;
        return $this;
    }

    /**
     * Return the size of this tuple.
     *
     * @return int
     */
    public function size()
    {
        return count($this->_data);
    }

    /**
     * Setter for data.
     *
     * @param array $data
     *
     * @return void
     */
    public function setData($data)
    {
        $this->_data = $data;
    }

    /**
     * Getter for data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->_data;
    }
}