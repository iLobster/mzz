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
 * NewsListModel: ��� ��� ������ list ������ news
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */

class newsFoldersView extends simpleView
{
    public function toString()
    {
        $this->smarty->assign('folders', $this->DAO);
        return $this->smarty->fetch('news.folders.tpl');
    }
}

?>