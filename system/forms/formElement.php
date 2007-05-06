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
 * formElement
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
abstract class formElement
{
    static protected $counts = array();
    static public function createTag(Array $options = array(), $name = 'input')
    {
        if (!isset($options['onError'])) {
            $options['onError'] = 'style=color: red;';
        }

        self::parseError($options);

        if (!$name) {
            return null;
        }
        $content = isset($options['content']) ? $options['content'] : false;
        unset($options['content']);

        if (self::isFreeze($options)) {
            $html = $options['value'];
        } else {
            $html = '<' . $name . self::optionsToString($options);
            if ($content !== false) {
                $html .= '>' . $content . '</' . $name . '>';
            } else {
                $html .= ' />';
            }
        }
        //$html .= "\r\n";
        return $html;
    }

    static public function isFreeze($options)
    {
        return isset($options['freeze']) && $options['freeze'];
    }

    static protected function isRequired($options)
    {
        $validator = systemToolkit::getInstance()->getValidator();
        return ($validator instanceof formValidator) ? $validator->isFieldRequired($options['name']) : null;
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

        if($pos = strpos($name, '[]')) {
            if (!isset(self::$counts[$name])) {
                self::$counts[$name] = 0;
            } else {
                self::$counts[$name]++;
            }
            $pos += 2;
            $name = str_replace('[]', '[' . self::$counts[$name] . ']', substr($name, 0, $pos)) . str_replace('[]', '[0]', substr($name, $pos));
        }
        $value = $request->get($name, 'mixed', SC_REQUEST);
        if (!is_null($value)) {
            return $value;
        } else {
            return $default;
        }
    }

    abstract static public function toString($options = array());
}
?>