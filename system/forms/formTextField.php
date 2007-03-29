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

fileLoader::load("forms/form");

class formTextField extends Form
{
    static public function toString($name, $value = null, $options = array())
    {
        $options = array_merge(array('type' => 'text', 'name' => $name, 'id' => $name, 'value' => $value), $options);
        return self::createTag('input', $options);
    }
}

?>