<?php

fileLoader::load('forms/validators/formAbstractRule');

class formNumericRule extends formAbstractRule
{
    public function validate()
    {
        return empty($this->value) || is_numeric($this->value);
    }
}

?>