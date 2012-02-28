<?php

/**
 * Implementation of the Erlang binary protocol.
 *
 * Provides facilities to work with Standard I/O streams, sockets, and
 * Erlang binary messages.
 */
namespace Hurricane\Erlang;

class Gateway
{
    /**
     * The raw device stream that to read/write to.
     *
     * @param StreamInterface
     */
    private $stream;

    /**
     * The stream wrapper that is used to abstract away the raw stream.
     *
     * @param StreamInterface
     */
    private $stream_wrapper;

    /**
     * Initialize with an optional stream. If no stream is provided,
     * Standard I/O will be used.
     *
     * @param StreamInterface|null $stream
     */
    public function __construct(StreamInterface $stream=null)
    {
        if ($stream) {
            $this->setStream($stream);
        } else {
            $this->setStream(new StdioWrapper());
        }
        $this->stream_wrapper = new StreamEmulator();
    }

    /**
     * Close any open stream and set the new one.
     *
     * @param StreamInterface $stream
     */
    public function setStream(StreamInterface $stream)
    {
        $this->close();
        $this->stream = $stream;
    }

    /**
     * If there is an active stream, close it.
     */
    private function close()
    {
        if ($this->stream) {
            $this->stream->close();
        }
    }

    /**
     * Receive one message from Hurricane.
     *
     * @return mixed
     */
    public function recv()
    {
        $message_len = $this->stream->read(4);

        if (strlen($message_len) < 4) {
            throw new Exception('Message size payload should be 4 bytes');
        }

        $message_len = reset(unpack('N', $message_len));
        $this->stream_wrapper->clear();
        $this->stream_wrapper->write($this->stream->read($message_len));
        $message = Util::decode($this->stream_wrapper);
        return $message;
    }

    /**
     * Send one message to Hurricane.
     *
     * @param mixed $message
     */
    public function send($message)
    {
        $this->stream_wrapper->clear();
        Util::encode($message, $this->stream_wrapper);
        $this->stream->write(pack('N', strlen($this->stream_wrapper->data)));
        $this->stream->write($this->stream_wrapper->data);
        $this->stream->flush();
    }
}
