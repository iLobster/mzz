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
 * pageAdminView: вид для метода admin модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */
class pageAdminView extends simpleView
{
    public function toString()
    {
        $router = $this->toolkit->getRouter();

        $this->smarty->assign('section_name', $this->request->get('section_name', 'string', SC_PATH));
        $this->smarty->assign('pages', $this->DAO->getItems());
        $this->smarty->assign('pageFolder', $this->DAO);
        return $this->smarty->fetch('page/admin.tpl');
    }
}

?>