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
        self::parseError($options);

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

    static protected function isRequired($options)
    {
        $validator = systemToolkit::getInstance()->getValidator();
        return $validator->isFieldRequired($options['name']);
    }

    static protected function parseError(& $options)
    {
        $hasErrors = false;

        $validator = systemToolkit::getInstance()->getValidator();
        if ($validator) {
            $errors = $validator->getErrors();
            if (isset($options['name']) && !is_null($errors->get($options['name']))) {
                $hasErrors = true;

                if (isset($options['onError'])) {
                    $onError = explode('=', $options['onError']);
                    $cnt = sizeof($onError);
                    for ($i=1; $i < $cnt; $i = $i + 2) {
                        $options[$onError[$i-1]] = $onError[$i];
                    }
                }
            }
        }
        unset($options['onError']);

        return $hasErrors;
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