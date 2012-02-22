<?php

namespace Erlang;

/**
 * Implements an Erlang binary.
 */
class Binary {
    /**
     * @var string
     */
    public $data;

    /**
     * Set the given data on the object.
     *
     * @param string $data
     *
     * @return void
     */
    public function __construct($data) {
        $this->data = $data;
    }
}