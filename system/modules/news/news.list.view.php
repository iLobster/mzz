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
 * NewsListModel: вид для метода list модуля news
 *
 * @package news
 * @version 0.1
 */

class newsListView extends simpleView
{
    public function toString()
    {
        $data = $this->model->getNewsList();
        $this->smarty->assign('news', $data);
        $this->smarty->assign('title', 'Новости -> Список');
        return $this->smarty->fetch('news.list.tpl');
    }
}

?>