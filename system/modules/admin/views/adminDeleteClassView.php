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
 * adminDeleteClassView: вид для метода deleteClass модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */
class adminDeleteClassView extends simpleView
{
    public function toString()
    {
        return $this->smarty->fetch('admin/deleteClass.tpl');
    }
}

?>