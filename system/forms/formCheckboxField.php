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

class formCheckboxField extends formElement
{
    static public function toString($options = array())
    {
        $options['type'] = 'checkbox';
        $value = self::getValue($options);

        if (!isset($options['values'])) {
            $values = array(0, 1);
        } else {
            $values = explode('|', $options['values']);
            unset($options['values']);
        }

        if (isset($options['text'])) {
            $text = $options['text'];
            unset($options['text']);

            $id = 'mzzForms_' . md5(microtime(true));
            $label = self::createContentTag('label', $text, array('for' => $id, 'style' => 'cursor: hand; cursor: pointer;'));

            $options['id'] = $id;
        }

        if (!in_array($value, $values)) {
            $value = $values[0];
        }

        if ($value == $values[1]) {
            $options['checked'] = 'checked';
        }

        $options['value'] = $values[1];

        $checkbox = self::createTag('input', $options);

        $optionsHidden = array('type' => 'hidden', 'name' => $options['name'], 'value' => $values[0]);
        $hidden = self::createTag('input', $optionsHidden);

        return $hidden . $checkbox . (isset($label) ? $label : '');
    }
}

?>