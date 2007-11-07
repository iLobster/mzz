<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load("forms/formElement");

/**
 * form: хелпер дл€ работы с формами
 *
 * @package system
 * @subpackage forms
 * @version 0.1.2
 */
class form
{

    public function open($params, $smarty)
    {
        fileLoader::load('forms/formTag');
        return formTag::toString($params);
    }

    public function text($params, $smarty = null)
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

    public function image($params, $smarty)
    {
        $params['type'] = 'image';
        return $this->text($params, $smarty);
    }

    public function submit($params, $smarty)
    {
        $params['type'] = 'submit';
        if (!isset($params['name'])) {
            throw new mzzRuntimeException('Ёлементу типа submit об€зательно нужно указывать им€');
        }
        $name = $params['name'];
        unset($params['name']);

        $submit = $this->text($params, $smarty);

        $hiddenParams = array();
        $hiddenParams['value'] = $params['value'];
        $hiddenParams['name'] = $name;
        return $this->hidden($hiddenParams, $smarty) . $submit;
    }

    public function reset($params, $smarty)
    {
        $params['type'] = 'reset';
        if (isset($params['jip']) && $params['jip']) {
            $params['onclick'] = (empty($params['onclick']) ? 'javascript:' : '') . ' jipWindow.close();';
            unset($params['jip']);
        }
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

    public function captcha($params, $smarty = null)
    {
        fileLoader::load('forms/formCaptchaField');
        return formCaptchaField::toString($params);
    }
}

?>