<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
*/

/**
 * accessDeleteUserDefaultView: вид для метода deleteUserDefault модуля access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */


class accessDeleteUserDefaultView extends simpleView
{
    public function toString()
    {
        return '<script>window.close();window.opener.location.reload();window.opener.focus();</script>';
    }
}

?>