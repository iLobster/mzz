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
 * accessAddUserView: вид для метода addUser модуля access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */


class accessAddUserView extends simpleView
{
    public function toString()
    {
        return $this->smarty->fetch('access.addUser.tpl');
    }
}

?>