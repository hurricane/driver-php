<?php

namespace Erlang;

/**
 * Wraps Standard I/O input and output facilities. Serves as a Gateway
 * transport.
 */
class StdioWrapper implements StreamInterface {
    /**
     * A handle to the Standard In stream.
     *
     * @var resource
     */
    private $in;

    /**
     * A handle to the Standard Out stream.
     *
     * @var resource
     */
    private $out;

    /**
     * Open Standard In and Standard Out.
     *
     * @return void
     */
    public function __construct() {
        $this->in = fopen('php://stdin', 'r');
        $this->out = fopen('php://stdout', 'w');
    }

    /**
     * Close Standard In and Standard Out.
     *
     * @return void
     */
    public function __destruct() {
        $this->close();
    }

    /**
     * Read data from the Standard In stream.
     *
     * @param integer $num
     *
     * @return string
     */
    public function read($num) {
        return fread($this->in, $num);
    }

    /**
     * Write data to the Standard Out stream.
     *
     * @param string $data
     *
     * @return void
     */
    public function write($data) {
        return fwrite($this->out, $data);
    }

    /**
     * Flush all data in the Standard Out buffer to the Standard Out
     * stream.
     *
     * @return void
     */
    public function flush() {
        fflush($this->out);
    }

    /**
     * Close Standard In and Standard Out.
     *
     * @return void
     */
    public function close() {
        fclose($this->in);
        fclose($this->out);
    }
}