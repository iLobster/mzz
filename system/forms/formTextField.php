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

fileLoader::load("forms/formElement");

class formTextField extends formElement
{
    static public function toString($name, $value = null, $options = array())
    {
        $value = self::getValue($name, $value);
        $options = array_merge(array('type' => 'text', 'name' => $name, 'id' => $name, 'value' => $value), $options);
        return self::createTag('input', $options);
    }

    static public function getValue($name, $default = '')
    {
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();
        if (($value = $request->get($name, 'mixed', SC_POST | SC_GET)) != null) {
            return $value;
        } else {
            return $default;
        }
    }
}

?>