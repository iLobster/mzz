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

abstract class formElement
{
    static public function createTag(Array $options = array(), $name = 'input')
    {
        if (!$name) {
            return null;
        }
        $content = isset($options['content']) ? $options['content'] : false;
        unset($options['content']);

        $html = '<' . $name . self::optionsToString($options);
        if ($content !== false) {
            $html .= '>' . $content . '</' . $name . '>';
        } else {
            $html .= ' />';
        }
        $html .= "\r\n";
        return $html;
    }

    static public function optionsToString(Array $options = array())
    {
        $html = '';

        foreach (array('disabled', 'readonly', 'multiple', 'checked', 'selected') as $attribute) {
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

    static public function getValue($name, $default = false)
    {
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();
        if (!is_null($value = $request->get($name, 'mixed', SC_REQUEST))) {
            return $value;
        } else {
            return $default;
        }
    }

    abstract static public function toString($options = array());
}

?>