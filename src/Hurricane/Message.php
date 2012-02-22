<?php

/**
 * Implementation of the Hurricane messaging utilities.
 *
 * Provides a way to deal with the gateway conveniently and a way to
 * represent messages.
 */
namespace Hurricane;

require_once dirname(__FILE__) . '../erl_codec.php'; // @todo autoload

class Message
{
    /**
     * The type of message being sent/received.
     *
     * @var string
     */
    private $_type;

    /**
     * The source/destination of the message. Can be a string or an
     * atom.
     *
     * @var mixed
     */
    private $_destination;

    /**
     * The message tag--used for keeping messages in order.
     *
     * @var mixed
     */
    private $_tag;

    /**
     * The message payload.
     *
     * @var mixed
     */
    private $_data;

    /**
     * The timeout of the message.
     *
     * @var integer
     */
    private $_timeout;

    /**
     * Constructs a new Hurricane message with default values.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_type = '';
        $this->_destination = '';
        $this->_tag = '';
        $this->_data = '';
        $this->_timeout = 10000;
    }

    /**
     * Facilitates the fluent API.
     *
     * @return Message A new message.
     */
    public static function create()
    {
        return new self();
    }

    /**
     * Getter for the type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * Setter for the type.
     *
     * @param string $type The type of the message.
     *
     * @return Message The object, for a fluent API.
     */
    public function setType($type)
    {
        $this->_type = $type;
        return $this;
    }

    /**
     * Getter for the source/destination.
     *
     * @return mixed
     */
    public function getDestination()
    {
        return $this->_destination;
    }

    /**
     * Setter for the destination.
     *
     * @param mixed $destination The destination of the message. Can be
     * a string or an atom.
     *
     * @return Message The object, for a fluent API.
     */
    public function setDestination($destination)
    {
        $this->_destination = $destination;
        return $this;
    }

    /**
     * Getter for the tag.
     *
     * @return mixed
     */
    public function getTag()
    {
        return $this->_tag;
    }

    /**
     * Setter for the tag.
     *
     * @param mixed $tag The tag of the message.
     *
     * @return Message The object, for a fluent API.
     */
    public function setTag($tag)
    {
        $this->_tag = $tag;
        return $this;
    }

    /**
     * Getter for the data.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * Setter for the data.
     *
     * @param mixed $data The data of the message.
     *
     * @return Message The object, for a fluent API.
     */
    public function setData($data)
    {
        $this->_data = $data;
        return $this;
    }

    /**
     * Getter for the timeout.
     *
     * @return integer
     */
    public function getTimeout()
    {
        return $this->_timeout;
    }

    /**
     * Setter for the timeout.
     *
     * @param mixed $timeout The timeout of the message.
     *
     * @return Message The object, for a fluent API.
     */
    public function setTimeout($timeout)
    {
        $this->_timeout = $timeout;
        return $this;
    }
}