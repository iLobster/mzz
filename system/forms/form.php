<?php

fileLoader::load("forms/formElement");

class form
{
    public function text($params, $smarty)
    {
        fileLoader::load('forms/formTextField');
        return formTextField::toString($params);
    }

    public function password($params, $smarty)
    {
        $params['type'] = 'password';
        return $this->text($params, $smarty);
    }

    public function hidden($params, $smarty)
    {
        $params['type'] = 'hidden';
        return $this->text($params, $smarty);
    }

    public function submit($params, $smarty)
    {
        $params['type'] = 'submit';
        return $this->text($params, $smarty);
    }

    public function checkbox($params, $smarty)
    {
        fileLoader::load('forms/formCheckboxField');
        return formCheckboxField::toString($params);
    }
}

?>