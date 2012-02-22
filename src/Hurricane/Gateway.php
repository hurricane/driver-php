<?php

/**
 * Implementation of the Hurricane messaging utilities.
 *
 * Provides a way to deal with the gateway conveniently and a way to
 * represent messages.
 */
namespace Hurricane;

require_once dirname(__FILE__) . '../erl_codec.php'; //@todo autoload

/**
 * Extends the Erlang Gateway to provide Hurricane-specific
 * functionality.
 */
class Gateway extends \Erlang\Gateway
{
    /**
     * Initialize with an optional stream. If no stream is provided,
     * Standard I/O will be used.
     *
     * @param \Erlang\StreamInterface $stream
     *
     * @return void
     */
    public function __construct(\Erlang\StreamInterface $stream=null)
    {
        parent::__construct($stream);
    }

    /**
     * Register with a named group in the Hurricane system.
     *
     * @param string $name The name of the server group.
     *
     * @return void
     */
    public function registerServer($name)
    {
        $this->send(
            new \Erlang\Tuple(array(
                new \Erlang\Atom('register_with_group'),
                new \Erlang\Atom($name)
            ))
        );
    }

    /**
     * When running over Standard I/O, indicate that the process has
     * successfully started up and is ready to receive requests.
     *
     * @return void
     */
    public function sendReadySignal($name)
    {
        $this->send(new \Erlang\Tuple(array(new Erlang\Atom('ready'))));
    }

    /**
     * Receive the next Hurricane message, turn it into a Message
     * object.
     *
     * @return Message The message that was received.
     */
    public function recv()
    {
        $data = parent::recv();
        $message = new Message();
        $message->setType($data->data[0]);
        $message->setDestination($data->data[1]);
        $message->setTag($data->data[2]);
        $message->setData($data->data[3]);
        return $message;
    }

    /**
     * Turn a message object into a Hurricane message and send it. Can
     * also send other message types if needed.
     *
     * @param mixed $message The data to send.
     *
     * @return Message The message that was received.
     */
    public function send($message)
    {
        if ($message instanceof Message) {
            $destination = $message->getDestination();
            if (is_string($destination)) {
                $destination = new \Erlang\Atom($destination);
            }

            $data = new \Erlang\Tuple(array(
                new \Erlang\Atom($message->getType()),
                $destination,
                $message->getTag(),
                $message->getData(),
                $message->getTimeout()
            ));
        } else {
            $data = $message;
        }

        parent::send($data);
    }
}
