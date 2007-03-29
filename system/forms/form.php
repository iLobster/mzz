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

abstract class Form
{
    static public function createTag($name, Array $options = array())
    {
        if (!$name) {
            return null;
        }
/*
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();
        if (($value = $request->get($options['name'], 'mixed', SC_POST | SC_GET)) != null) {
            $options['value'] = $value;
        }*/

        return '<' . $name . self::optionsToString($options) . ' />';
    }

    static public function createContentTag($name, $content = '', $options = array())
    {
        if (!$name) {
            return null;
        }

        return '<' . $name . self::optionsToString($options) . '>' . $content . '</' . $name . '>';
    }

    static public function optionsToString(Array $options = array())
    {
        $html = '';

        foreach (array('disabled', 'readonly', 'multiple') as $attribute) {
            if (isset($options[$attribute])) {
                if ($options[$attribute]) {
                    $options[$attribute] = $attribute;
                } else {
                    unset($options[$attribute]);
                }
            }
        }
        ksort($options);
        foreach ($options as $key => $value) {
            $html .= ' ' . $key . '="' . self::escapeOnce($value) . '"';
        }
        return $html;
    }

    static protected function escapeOnce($value)
    {
        return preg_replace('/&amp;([a-z]+|(#\d+)|(#x[\da-f]+));/i', '&$1;', htmlspecialchars($value));
    }

}
?>