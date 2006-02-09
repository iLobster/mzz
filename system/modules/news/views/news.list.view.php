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
 * @package news
 * @version 0.1
 */

class newsListView extends simpleView
{
    public function toString()
    {
        if(!$this->smarty->is_cached('news.list.tpl')) {
            $this->smarty->assign('news', $this->DAO);
            $this->smarty->assign('title', '������� -> ������');
        }
        return $this->smarty->fetch('news.list.tpl');
    }
}

?>