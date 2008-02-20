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
            $type = substr($options['autocomplete'], 0, 1) == '[' ? 'local' : 'ajax';
            $id = isset($options['id']) ? $options['id'] : '__autocompleter_' . $i++;
            $div = array('id' => $id . '_autocompleter', 'class' => 'autocomplete');
            $autocomplete .= self::buildTag($div, 'div', '');
            $content = 'var ' . $id . "_autocompleter = new ";
            $content .= $type == 'local' ? 'Autocompleter.Local' : 'Ajax.Autocompleter';
            $content .= "('" . $id . "', '" . $id . "_autocompleter', ";
            if ($type == 'local') {
                $content .= $options['autocomplete'];
            } else {
                $content .= "'" . SITE_PATH . $options['autocomplete'] . "'";
            }
            $content .= ", (autocompleterOptions && autocompleterOptions." . $id . ") ? autocompleterOptions." . $id . ' : {});';
            $js = array('type' => 'text/javascript');
            $autocomplete .= self::buildTag($js, 'script', $content);
            unset($options['autocomplete']);
            $options['id'] = $id;
        }

        return self::createTag($options) . $autocomplete;
    }
}

?>