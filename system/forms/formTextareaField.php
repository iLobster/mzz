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
 * formTextareaField: текстарея
 *
 * @package system
 * @subpackage forms
 * @version 0.1.1
 */
class formTextareaField extends formElement
{
    static public function toString($options = array())
    {
        $value = isset($options['value']) ? $options['value'] : '';
        if (isset($options['name'])) {
            $options['content'] = self::getValue($options['name'], $value);
        }
        unset($options['value']);
        if (is_null($options['content'])) {
            $options['content'] = '';
        }
        return self::createTag($options, 'textarea');
    }
}

?>