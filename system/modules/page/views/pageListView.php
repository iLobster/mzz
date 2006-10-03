<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * pageListModel: вид для метода list модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.2
 */

class pageListView extends simpleView
{
    public function toString()
    {
        $this->smarty->assign('pages', $this->DAO);
        $this->response->setTitle('Страницы -> Список');
        return $this->smarty->fetch('page.list.tpl');
    }
}

?>