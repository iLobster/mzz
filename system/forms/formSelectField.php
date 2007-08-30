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
 * formSelectField: ���������� ������
 *
 * @package system
 * @subpackage forms
 * @version 0.1.1
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
        if (!isset($options['styles']) || !is_array($options['styles'])) {
            $options['styles'] = array();
        }
        if (isset($options['emptyFirst']) && $options['emptyFirst']) {
            $options['options'] = array('' => '&nbsp;') + $options['options'];
        }

        if (sizeof($options['options']) < 2 && isset($options['one_item_freeze']) && $options['one_item_freeze']) {
            $options['freeze'] = true;
        }
        if (is_array($options['options'])) {
            $value = self::getValue($name, $value);
            foreach ($options['options'] as $key => $text) {
                $text_array = array();
                if (is_array($text)) {
                    $text_array = $text;
                    $text = $text['content'];
                    unset($text_array['content']);
                }
                $selected = ((string)$key == (string)$value);
                if ($selected) {
                    $value_selected = array($key, $text);
                }
                $style = isset($options['styles'][$key]) ? $options['styles'][$key] : false;
                if ($selected) {
                    $style = "font-weight: bold;";
                }

                $options_for_tag = array('content' => $text, 'style' => $style, 'value' => $key, 'selected' => $selected);

                foreach ($text_array as $key => $value2) {
                    if ($key == 'items') {
                        continue;
                    }
                    $options_for_tag[$key] = $valu2;
                }

                if (isset($text_array['items'])) {
                    $options_for_tag['label'] = $options_for_tag['content'];
                    unset($options_for_tag['value']);

                    $tmp = '';
                    foreach ($text_array['items'] as $key => $item) {
                        $item['value'] = $key;

                        if ($key == $value) {
                            $item['selected'] = 'selected';
                        }

                        $tmp .= self::createTag($item, 'option');
                    }

                    $options_for_tag['content'] = $tmp;

                    $html .= self::createTag($options_for_tag, 'optgroup');
                } else {
                    $html .= self::createTag($options_for_tag, 'option');
                }
            }
        } elseif (!empty($options['options']) && is_scalar($options['options'])) {
            $html .= self::createTag(array('content' => $options['options'], 'value' => null), 'option');
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
            unset($options['styles']);

            $options = array_merge($options, array('content' => $html));
            $select = self::createTag($options, 'select');
        }
        return $select;
    }
}

?>
