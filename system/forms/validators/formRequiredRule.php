<?php

fileLoader::load('forms/validators/formAbstractRule');

class formRequiredRule extends formAbstractRule
{
    public function validate()
    {
        return $this->value != '';
    }
}

?>