<?php

class form
{
    [...]
        
    public function text($params, $smarty)
    {
        fileLoader::load('forms/formTextField');
        return formTextField::toString($params);
    }
    
    [...]
}

?>