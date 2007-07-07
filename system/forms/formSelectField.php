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
 * formSelectField: выпадающий список
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formSelectField extends formElement
{
    static public function toString($options = array())
    {
        $html = '';
        $value = isset($options['value']) ? $options['value'] : '';

        if (isset($options['multiple']) && $options['multiple'] && substr($options['name'], -2) !== '[]') {
            $options['name'] .= '[]';
        }

        $name = $options['name'];

        if (!isset($options['options'])) {
            $options['options'] = array();
        }
        if (isset($options['emptyFirst']) && $options['emptyFirst']) {
            $options['options'] = array('' => '&nbsp;') + $options['options'];
        }

        if (sizeof($options['options']) < 2 && isset($options['one_item_freeze']) && $options['one_item_freeze']) {
            $options['freeze'] = true;
        }

        foreach ($options['options'] as $key => $text) {
            $value = self::getValue($name, $value);
            $selected = ((string)$key == (string)$value);
            if ($selected) {
                $value_selected = array($key, $text);
            }
            $html .= self::createTag(array('content' => $text, 'value' => $key, 'selected' => $selected), 'option');
        }

        if (self::isFreeze($options)) {
            reset($options['options']);
            // hide current value
            $value = isset($value_selected) ? $value_selected[0] : key($options['options']);
            $params = array('name' => $name, 'value' => $value, 'type' => 'hidden');
            $select = form::text($params);

            $select .= isset($value_selected) ? $value_selected[1] : current($options['options']);
        } else {
            unset($options['options']);
            unset($options['value']);
            unset($options['emptyFirst']);

            $options = array_merge($options, array('content' => $html));
            $select = self::createTag($options, 'select');
        }
        return $select;
    }
}

?>