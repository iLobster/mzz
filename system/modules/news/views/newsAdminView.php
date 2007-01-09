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
        $router = $this->toolkit->getRouter();

        $this->smarty->assign('section_name', $this->request->get('section_name', 'string', SC_PATH));
        $this->smarty->assign('news', $this->DAO->getItems());
        $this->smarty->assign('newsFolder', $this->DAO);
        return $this->smarty->fetch('news/admin.tpl');
    }
}

?>