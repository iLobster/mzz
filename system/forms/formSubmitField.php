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
 * formSubmitField: submit
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formSubmitField extends formElement
{
    static public function toString($options = array())
    {
        $options['type'] = 'submit';
        if (!isset($options['name'])) {
            throw new mzzRuntimeException('Элементу типа submit обязательно нужно указывать имя');
        }

        $name = $options['name'];

        $hidden = '';
        if (empty($options['nodefault'])) {
            $hiddenParams = array();
            $hiddenParams['type'] = 'hidden';
            $hiddenParams['value'] = $options['value'];
            $hiddenParams['name'] = $name;
            $hidden = self::createTag($hiddenParams);
        } else {
            unset($options['nodefault']);
        }

        if (!isset($options['value']) || $options['type'] == 'password') {
            $options['value'] = '';
        }

        return $hidden . self::createTag($options);
    }
}

?>