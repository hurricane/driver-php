<?php

namespace Hurricane\Erlang\DataType;

/**
 * Implements a tuple object to be used with Erlang messaging.
 */
class Tuple implements \ArrayAccess, \Countable, \IteratorAggregate
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
    public function __construct($data = array())
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

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean Returns true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return isset($this->_data[$offset]);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return $this->_data[$offset];
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->_data[$offset] = $value;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->_data[$offset]);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count()
    {
        return count($this->_data);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing Iterator or
     * Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->_data);
    }
}