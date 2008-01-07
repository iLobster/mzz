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
 * formTextField: однострочное поле редактирования
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formTextField extends formElement
{
    static public function toString($options = array())
    {
        if (!isset($options['type'])) {
            $options['type'] = 'text';
        }

        if (!isset($options['value']) || $options['type'] == 'password') {
            $options['value'] = '';
        }

        if (isset($options['name'])) {
            $options['value'] = self::getValue($options['name'], $options['value']);
        }

        return self::createTag($options);
    }
}

?>