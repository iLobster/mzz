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
 * @version 0.1.1
 */
class formTextField extends formElement
{
    static public function toString($options = array())
    {
        static $i = 0;
        if (!isset($options['type'])) {
            $options['type'] = 'text';
        }

        $smarty = systemToolkit::getInstance()->getSmarty();

        if (!isset($options['value']) || $options['type'] == 'password') {
            $options['value'] = '';
        }

        if (isset($options['name'])) {
            $options['value'] = self::getValue($options['name'], $options['value']);
        }

        $autocomplete = '';
        if (isset($options['autocomplete']) && $options['autocomplete']) {
            $type = substr($options['autocomplete'], 0, 1) == '[' ? 'local' : 'ajax';
            $id = isset($options['id']) ? $options['id'] : '__autocompleter_' . $i++;
            $smarty->assign('id', $id);
            $smarty->assign('type', $type);
            $smarty->assign('data', $options['autocomplete']);
            $autocomplete = $smarty->fetch('forms/autocomplete.tpl');
            unset($options['autocomplete']);
            $options['id'] = $id;
        }

        return self::createTag($options) . $autocomplete;
    }
}

?>