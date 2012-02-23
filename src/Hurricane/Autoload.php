<?php

namespace Hurricane;

/**
 * Optional autoloader. Since Hurricane follows PSR-0 standards,
 * most framework autoloaders will suffice.
 *
 * @see https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
 */
class Autoload
{
    /**
     * @static
     * @return void
     */
    public static function registerSpl()
    {
        spl_autoload_register(function($class){
            $file = implode(DIRECTORY_SEPARATOR, explode('\\', $class)) . '.php';
            require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $file;
        });
    }
}
