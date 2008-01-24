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

        if (!isset($options['value']) || $options['type'] == 'password') {
            $options['value'] = '';
        }

        if (isset($options['name'])) {
            $options['value'] = self::getValue($options['name'], $options['value']);
        }

        $autocomplete = '';
        if (isset($options['autocomplete']) && $options['autocomplete']) {
            $id = isset($options['id']) ? $options['id'] : '__autocompleter_' . $i++;
            $div = array('id' => $id . '_autocompleter', 'class' => 'autocomplete');
            $autocomplete .= self::buildTag($div, 'div', '');
            $content = 'var ' . $id . "_autocompleter = new Ajax.Autocompleter('" . $id . "', '" . $id . "_autocompleter', '" . SITE_PATH . $options['autocomplete'] . "', (autocompleterOptions && autocompleterOptions." . $id . ") ? autocompleterOptions." . $id . ' : {});';
            $js = array('type' => 'text/javascript');
            $autocomplete .= self::buildTag($js, 'script', $content);
            unset($options['autocomplete']);
        }

        return self::createTag($options) . $autocomplete;
    }
}

?>