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
 * formRadioField: радио-кнопка
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formRadioField extends formElement
{
    static public function toString($options = array())
    {
        static $i = 0;

        if (isset($options['text'])) {
            $text = $options['text'];
            unset($options['text']);

            $id = 'mzzFormsRadio_' . $i;
            $i++;
            $label = self::createTag(array('for' => $id, 'style' => 'cursor: pointer; cursor: hand;', 'content' => $text), 'label');

            $options['id'] = $id;
        }
        $options['type'] = 'radio';
        $value = $options['value'];

        $requestValue = self::getValue($options['name']);

        if ((string)$value === $requestValue) {
            $options['checked'] = true;
        } elseif ($requestValue !== false) {
            unset($options['checked']);
        }

        if (isset($options['values'])) {
            unset($options['values']);
        }

        $checkbox = self::createTag($options);

        return $checkbox . (isset($label) ? $label : '');
    }
}

?>