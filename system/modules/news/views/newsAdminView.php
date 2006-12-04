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
 * newsAdminView: вид для метода admin модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */


class newsAdminView extends simpleView
{
    public function toString()
    {
        return $this->smarty->fetch('news/admin.tpl');
    }
}

?>