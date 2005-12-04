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

class newsViewView extends simpleView
{
    public function toString()
    {
        $data = $this->model->getNews();
        $this->smarty->assign('news', $data);
        $this->smarty->assign('title', '������� -> �������� -> ' . $data['title']);
        return $this->smarty->fetch('news.view.tpl');
    }

}

?>