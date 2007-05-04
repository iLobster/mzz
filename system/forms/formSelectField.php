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

class formSelectField extends formElement
{
    static public function toString($options = array())
    {
        $html = '';
        $value = isset($options['value']) ? $options['value'] : '';
        $name = $options['name'];

        if (isset($options['null']) && $options['null']) {
            $options['options'] = array('' => '') + $options['options'];
        }

        if (sizeof($options['options']) < 2 && isset($options['one_item_freeze']) && $options['one_item_freeze']) {
            $options['freeze'] = true;
        }

        foreach ($options['options'] as $key => $text) {
            $value = self::getValue($name, $value);
            $selected = ((string)$key == (string)$value);
            if ($selected) {
                $value_selected = $text;
            }
            $html .= self::createTag(array('content' => $text, 'value' => $key, 'selected' => $selected), 'option');
        }

        if (self::isFreeze($options)) {
            reset($options['options']);
            $select = isset($value_selected) ? $value_selected : current($options['options']);
        } else {
            unset($options['options']);
            unset($options['value']);
            unset($options['null']);

            $options = array_merge($options, array('content' => $html));
            $select = self::createTag($options, 'select');
        }
        return $select;
    }
}

?>