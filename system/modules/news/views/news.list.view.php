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
    protected $newsFolderMapper;

    public function __construct($news, $newsFolderMapper)
    {
        $this->newsFolderMapper = $newsFolderMapper;
        parent::__construct($news);
    }

    public function toString()
    {
        $this->smarty->assign('news', $this->DAO);
        $this->smarty->assign('newsFolder', $this->newsFolderMapper);
        //echo'<pre>';print_r($this->newsFolder->getFolders(1)); echo'</pre>';

        // ������ �������� ������� ����� ???
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();
        if (($path = $httprequest->get(0, SC_PATH)) == false) {
            $path = "root";
        }
        $this->smarty->assign('folderPath', $path);

        // ������ ����� ���������� ��� ��� �������� ;)
        fileLoader::load('pager');
        $pager = new pager('/news/list', 7, 10, 95);
        $this->smarty->assign('pager', $pager->toString());

        $this->response->setTitle('������� -> ������');
        return $this->smarty->fetch('news.list.tpl');
    }
}

?>