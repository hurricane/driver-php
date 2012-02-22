<?php

namespace Erlang;

/**
 * Implements a tuple object to be used with Erlang messaging.
 */
class Tuple {
    /**
     * @var array
     */
    public $data;

    /**
     * Set the given data on the object.
     *
     * @param array $data
     *
     * @return void
     */
    public function __construct($data) {
        $this->data = $data;
    }
}