<?php

class formRequiredRule
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function validate()
    {
        return (bool)$this->value;
    }
}

?>