<?php

error_reporting(E_ALL | E_STRICT);

$autoload = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoload.php';
if (is_file($autoload)) {
    require_once $autoload;
} else {
    require_once $autoload . '.dist';
}

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Hurricane' .
                       DIRECTORY_SEPARATOR . 'Support' .
                       DIRECTORY_SEPARATOR . 'TestHelper.php';