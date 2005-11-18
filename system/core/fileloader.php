<?php

class fileLoader
{
    private static $resolver;
    public function setResolver($resolver)
    {
        self::$resolver = $resolver;
    }
    
    public function resolve($request)
    {
        return self::$resolver->resolve($request);
    }
    
    public function load($classname)
    {
        $realname = (strpos($classname, '/') === false ) ? $classname : substr(strrchr($classname, '/'), 1);
        if (class_exists($realname)) {
            return true;
        } elseif($filename = self::resolve($classname)) {
            require_once $filename;
            return true;
        } else {
            // тут бросать эксепшн как у сида
            return false;
        }
    }
}

?>