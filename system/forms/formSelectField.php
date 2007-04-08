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
        $value = self::getValue($options['name']);
        $options['options'] = array_merge(array('' => ''), $options['options']);
        foreach ($options['options'] as $key => $text) {
            $html .= self::createTag(array('content' => $text, 'value' => $key, 'selected' => $key == $value), 'option');
        }
        unset($options['options']);
        unset($options['value']);

        $options = array_merge($options, array('content' => $html));
        $select = self::createTag($options, 'select');
        return $select;
    }
}

?>