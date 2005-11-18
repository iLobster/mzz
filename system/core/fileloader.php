<?php

class fileLoader
{
    private $resolver;
    public function setResolver($resolver)
    {
        $this->resolver = $resolver;
    }
    
    public function resolve($request)
    {
        return $this->resolver->resolve($request);
    }
    
    public function load($request)
    {
        
    }
}

?>