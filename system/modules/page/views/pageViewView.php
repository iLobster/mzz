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
 * pageViewView: вид для метода view модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */

class pageViewView extends simpleView
{
    public function toString()
    {
        $this->smarty->assign('page', $this->DAO);
        $this->response->setTitle('Страницы -> ' . $this->DAO->getTitle());
        return $this->smarty->fetch('page/view.tpl');
    }
}

?>