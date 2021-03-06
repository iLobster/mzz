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

fileLoader::load('forms/validators/formHostnameRule');

/**
 * formEmailRule: правило, проверяющее имя хоста
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formEmailRule extends formAbstractRule
{
    protected function _validate($value)
    {
        if (!preg_match('/^(.+)@([^@]+)$/', $value, $matches)) {
            return false;
        }

        $name = $matches[1];
        $hostname = $matches[2];

        $hostnameValidator = new formHostnameRule();
        if (!$hostnameValidator->validate($hostname)) {
            return false;
        }

        $validChars = 'a-zA-Z0-9\x21\x23\x24\x25\x26\x27\x2a\x2b\x2d\x2f\x3d\x3f\x5e\x5f\x60\x7b\x7c\x7d';
        return preg_match('/^[' . $validChars . ']+(\x2e+[' . $validChars . ']+)*$/', $name);
    }
}

?>