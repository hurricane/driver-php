<?php

namespace Hurricane;

class Autoload
{
    /**
     * @static
     */
    public static function registerSpl()
    {
        spl_autoload_register(function($class){
            $file = implode(DIRECTORY_SEPARATOR, explode('\\', $class)) . '.php';
            require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $file;
        });
    }
}
