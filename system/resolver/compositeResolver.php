<?php

class compositeResolver
{
    private $resolvers = array();
    public function addResolver($resolver)
    {
        $this->resolvers[] = $resolver;
    }
    public function resolve($request)
    {
        foreach ($this->resolvers as $resolver) {
            if (null !== ($filename = $resolver->resolve($request))) {
                return $filename;
            }

        }
        return null;
    }
}

?>