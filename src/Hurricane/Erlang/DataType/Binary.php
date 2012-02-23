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
    public $data;

    /**
     * Set the given data on the object.
     *
     * @param string $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
}