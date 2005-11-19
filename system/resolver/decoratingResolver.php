<?php

abstract class decoratingResolver
{
    protected $resolver = NULL;

    public function __construct($resolver) {
        $this->resolver = $resolver;
    }
    public function resolve($request) {
       return $this->resolver->resolve($request);
    }
    public function __call($callname, $args)
    {
        if (method_exists($this->resolver, $callname)) {
            return call_user_func_array(array($this->resolver, $callname), $args);
        } else {
            echo "Exception 'method not found'";
        }
    }
}
?>