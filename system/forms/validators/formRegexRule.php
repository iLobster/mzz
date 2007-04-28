<?php

fileLoader::load('forms/validators/formAbstractRule');

class formRegexRule extends formAbstractRule
{
    public function validate()
    {
        return empty($this->value) || preg_match($this->params, $this->value);
    }
}

?>