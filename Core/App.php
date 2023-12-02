<?php

namespace Core;

class App
{

    protected static $registry = [];

    public static function bind($key, $resolver)
    {
        static::$registry[$key] = $resolver;
    }

    public static function resolver($key)
    {
        if (!array_key_exists($key, static::$registry)) {
            throw new \Exception("No match found for the {$key}");
        }
        return static::$registry[$key];
    }

}

?>