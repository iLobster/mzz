<?php

fileLoader::load('forms/validators/formAbstractRule');

class formNumericRule extends formAbstractRule
{
    public function validate()
    {
        return is_numeric($this->value);
    }
}

?>