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

    public function reset($params, $smarty)
    {
        $params['type'] = 'reset';
        return $this->text($params, $smarty);
    }

    public function checkbox($params, $smarty)
    {
        fileLoader::load('forms/formCheckboxField');
        return formCheckboxField::toString($params);
    }

    public function radio($params, $smarty)
    {
        fileLoader::load('forms/formRadioField');
        return formRadioField::toString($params);
    }

    public function select($params, $smarty)
    {
        fileLoader::load('forms/formSelectField');
        return formSelectField::toString($params);
    }

    public function textarea($params, $smarty)
    {
        fileLoader::load('forms/formTextareaField');
        return formTextareaField::toString($params);
    }
}

?>