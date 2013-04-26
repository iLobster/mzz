<?php

abstract class formAbstractFilter
{
    protected $options;

    public function __construct($options)
    {
        $this->options = $options;
    }

    abstract public function filter($value);
}

?>