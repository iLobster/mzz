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
    protected $newsFolder;

    public function __construct($news, $newsFolder)
    {
        $this->newsFolder = $newsFolder;
        parent::__construct($news);
    }

    public function toString()
    {
        $this->smarty->assign('news', $this->DAO);
        $this->smarty->assign('newsFolder', $this->newsFolder);

        // ������ �������� ������� ����� ???
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();
        $this->smarty->assign('folderName', $httprequest->get(0, SC_PATH));

        $this->response->setTitle('������� -> ������');
        return $this->smarty->fetch('news.list.tpl');
    }
}

?>