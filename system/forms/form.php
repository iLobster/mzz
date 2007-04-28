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
        if (!isset($params['name'])) {
            throw new mzzRuntimeException('�������� ���� submit ����������� ����� ��������� ���');
        }
        $submit = $this->text($params, $smarty);
        if (isset($params['id'])) {
            unset($params['id']);
        }
        return $this->hidden($params, $smarty) . $submit;
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

    public function caption($params, $smarty)
    {
        fileLoader::load('forms/formCaptionField');
        return formCaptionField::toString($params);
    }

    public function file($params, $smarty)
    {
        fileLoader::load('forms/formFileField');
        return formFileField::toString($params);
    }
}

?>