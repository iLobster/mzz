<?php

class partialFileResolver
{
    private $resolver;
    
    public function __construct($resolver)
    {
        $this->resolver = $resolver;
    }
    
    public function resolve($request)
    {
        return $this->resolver->resolve($this->partialResolve($request));
    }
    
    protected function partialResolve($request)
    {
        return str_replace('*', '', $request);
    }
}

?>