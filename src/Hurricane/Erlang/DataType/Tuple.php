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
    public $data;

    /**
     * Set the given data on the object.
     *
     * @param array $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
}