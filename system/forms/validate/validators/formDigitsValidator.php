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

class formDigitsValidator
{
    public function isValid($value)
    {
        if ($value !== '' && !preg_match('/^-?\d+$/', $value)) {
            return false;
        }
        return true;
    }
}
?>