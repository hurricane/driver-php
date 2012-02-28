<?php

/**
 * Implementation of the Erlang binary protocol.
 *
 * Provides facilities to work with Standard I/O streams, sockets, and
 * Erlang binary messages.
 */
namespace Hurricane\Erlang;

/**
 * Provides an Exception type that can be thrown and caught for
 * Erlang-related operations.
 */
class Exception extends \Exception {}