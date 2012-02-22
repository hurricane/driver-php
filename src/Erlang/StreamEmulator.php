<?php

/**
 * Implementation of the Erlang binary protocol.
 *
 * Provides facilities to work with Standard I/O streams, sockets, and
 * Erlang binary messages.
 */
namespace Erlang;

/**
 * Emulates a stream. Highly useful for debugging.
 */
class StreamEmulator implements StreamInterface {
    /**
     * The data buffer used to store bytes.
     *
     * @var string
     */
    public $data;

    /**
     * The current position in the data buffer (for reads).
     *
     * @var integer
     */
    public $pos;

    /**
     * Initialize the stream emulator with an optional data argument.
     *
     * @param $data string|array
     *
     * @return void
     */
    public function __construct($data=null) {
        $this->pos = 0;

        if (!$data) {
            $this->data = '';
        } else if (is_array($data)) {
            $this->data = Util::to_binary($data);
        } else {
            $this->data = $data;
        }
    }

    /**
     * Read bytes number of data and return it. Throw an Exception if there
     * aren't enough bytes to be read.
     *
     * @param $bytes integer
     *
     * @return string
     */
    public function read($bytes) {
        if (strlen($this->data) < $this->pos + $bytes) {
            throw new Exception(
                'Out of data to read (was asked for ' .
                $bytes . ' bytes(s), only ' .
                (strlen($this->data) - $this->pos) . ' byte(s) remain.'
            );
        }

        $read_data = substr($this->data, $this->pos, $bytes);
        $this->pos += $bytes;
        return $read_data;
    }

    /**
     * Write binary data to the stream.
     *
     * @param $data string
     *
     * @return void
     */
    public function write($data) {
        $this->data .= $data;
    }

    /**
     * Exist for interface completeness.
     *
     * @return void
     */
    public function flush() {
    }

    /**
     * Reset the position and clear the data buffer.
     *
     * @return void
     */
    public function clear() {
        $this->data = '';
        $this->pos = 0;
    }

    /**
     * Exist for interface completeness.
     *
     * @return void
     */
    public function close() {}
}