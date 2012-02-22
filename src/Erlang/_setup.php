<?php

/**
 * Implementation of the Erlang binary protocol.
 *
 * Provides facilities to work with Standard I/O streams, sockets, and
 * Erlang binary messages.
 */
namespace Erlang;


if (!defined('MACHINE_ENDIANNESS')) {
    if (reset(unpack('L', "\x00\x00\x00\x01")) == 1) {
        define('MACHINE_ENDIANNESS', 'BIG_ENDIAN');
    } else {
        define('MACHINE_ENDIANNESS', 'LITTLE_ENDIAN');
    }
}