<?php

/**
 * bootstrap hurricane
 *
 * @todo - move Erlang/_setup.php to Util.php
 * @todo - figure out how to encapsulate MACHINE_ENDIANNESS
 * @todo - setup autoload, remove this file
 * @todo - update README
 */

require_once __DIR__ . '/Erlang/_setup.php';
require_once __DIR__ . '/Erlang/Atom.php';
require_once __DIR__ . '/Erlang/AtomCacheRef.php';
require_once __DIR__ . '/Erlang/Binary.php';
require_once __DIR__ . '/Erlang/BitBinary.php';
require_once __DIR__ . '/Erlang/ErlFunction.php';
require_once __DIR__ . '/Erlang/Exception.php';
require_once __DIR__ . '/Erlang/Export.php';
require_once __DIR__ . '/Erlang/Gateway.php';
require_once __DIR__ . '/Erlang/NewFunction.php';
require_once __DIR__ . '/Erlang/NewReference.php';
require_once __DIR__ . '/Erlang/Pid.php';
require_once __DIR__ . '/Erlang/Port.php';
require_once __DIR__ . '/Erlang/Reference.php';
require_once __DIR__ . '/Erlang/Serializable.php';
require_once __DIR__ . '/Erlang/SocketWrapper.php';
require_once __DIR__ . '/Erlang/StdioWrapper.php';
require_once __DIR__ . '/Erlang/StreamEmulator.php';
require_once __DIR__ . '/Erlang/StreamInterface.php';
require_once __DIR__ . '/Erlang/Tuple.php';
require_once __DIR__ . '/Hurricane/Gateway.php';
require_once __DIR__ . '/Hurricane/Message.php';