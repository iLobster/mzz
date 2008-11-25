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

/**
 * formCaptionField: заголовок поля формы
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formCaptionField extends formElement
{
    public function __construct()
    {
        $this->setAttribute('onRequired', '%s <span style="color: red;">*</span>');
        $this->setAttribute('onError', '<span style="color: red;">%s</span>');
        $this->setAttribute('value', '');
        $this->setAttribute('name', '');
        $this->addOptions(array('onRequired', 'value', 'label'));
    }

    public function render($attributes = array(), $value = null)
    {
        $result = $attributes['value'];

        if ($this->parseError($attributes)) {
            $error = array_key_exists('onError', $attributes) ? $attributes['onError'] : $this->getAttribute('onError');
            $result = $error ? sprintf($error, $result) : $result;
        }

        if ($this->isRequired($attributes)) {
            $required = array_key_exists('onRequired', $attributes) ? $attributes['onRequired'] : $this->getAttribute('onRequired');
            $result = $required ? sprintf($required, $result) : $result;
        }

        if (!isset($attributes['label']) || $attributes['label'] != 0) {
            if (!array_key_exists('for', $attributes)) {
                $for = $this->generateId($attributes['name'], $this->getIdFormat());
            } else {
                $for = $attributes['for'];
            }
            $attributes = array('for' => $for, 'id' => $for . '_label', 'content' => $result);
            return $this->renderTag('label', $attributes);
        }
        return $result;
    }
}

?>