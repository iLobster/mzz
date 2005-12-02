<?php

class fileLoader
{
    private static $stack = array();
    private static $resolver;
    public function setResolver($resolver)
    {
        array_push(self::$stack, self::$resolver);
        self::$resolver = $resolver;
    }

    public function restoreResolver()
    {
        self::$resolver = array_pop(self::$stack);
    }

    public static function resolve($request)
    {
        return self::$resolver->resolve($request);
    }

    public static function load($classname)
    {
        $realname = (strpos($classname, '/') === false ) ? $classname : substr(strrchr($classname, '/'), 1);
        if (class_exists($realname)) {
            return true;
        } else {
            try {
                if(!($filename = self::resolve($classname))) {
                    throw new FileResolverException("Can't find file for class '" . $classname . "'");
                    return false;
                }
                require_once $filename;
                return true;
            } catch (FileResolverException $e) {
                $e->printHtml();
            }
            // тут бросать эксепшн как у сида
            return false;
        }
    }
}

?>