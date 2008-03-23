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
 * formCheckboxField: чекбокс
 *
 * @package system
 * @subpackage forms
 * @version 0.1.1
 */
class formCheckboxField extends formElement
{
    static public function toString($options = array())
    {
        static $i = 0;

        $options['type'] = 'checkbox';
        $value = self::getValue($options['name'], $options['value']);

        if (isset($options['values'])) {
            $values = explode('|', $options['values']);
            unset($options['values']);
        } else {
            $values = array(0, 1);
        }

        if (isset($options['text'])) {
            $text = $options['text'];
            unset($options['text']);
            if (isset($options['id'])) {
                $id = $options['id'];
            } else {
                $id = 'mzzFormsCheckbox_' . $i;
                $i++;
            }

            $label = self::createTag(array('for' => $id, 'style' => 'cursor: pointer; cursor: hand;', 'content' => $text), 'label');
            $options['id'] = $id;
        }

        if (!in_array($value, $values)) {
            $value = $values[0];
        }

        if ($value == $values[1]) {
            $options['checked'] = true;
        }

        $options['value'] = $values[1];

        $hidden = '';
        if (!isset($options['nodefault']) || !$options['nodefault']) {
            $optionsHidden = array('type' => 'hidden', 'name' => $options['name'], 'value' => $values[0]);
            $hidden = self::createTag($optionsHidden);
        }
        if (isset($options['nodefault'])) {
            unset($options['nodefault']);
        }

        $checkbox = self::createTag($options);

        return $hidden . $checkbox . (isset($label) ? ' ' . $label : '');
    }
}

?>