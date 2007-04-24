<?php

fileLoader::load('forms/validators/formAbstractRule');

class formCallbackRule extends formAbstractRule
{
    public function validate()
    {
        $funcName = array_shift($this->params);
        return call_user_func_array($funcName, $this->params);
    }
}

?>