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
    protected $newsFolderMapper;

    public function __construct($news, $newsFolderMapper)
    {
        $this->newsFolderMapper = $newsFolderMapper;
        parent::__construct($news);
    }

    public function toString()
    {
        $this->smarty->assign('news', $this->DAO->getItems());
        $this->smarty->assign('newsFolder', $this->newsFolderMapper);
        //echo'<pre>';print_r($this->newsFolder->getFolders(1)); echo'</pre>';

        //var_dump($this->newsFolderMapper->getCount());

        // откуда получать текущую папку ???
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();
        if (($path = $httprequest->get(0, SC_PATH)) == false) {
            $path = "root";
        }
        $this->smarty->assign('folderPath', $path);


        $tmp = $httprequest->get('page', SC_GET);

        $page = (!empty($tmp)) ? $tmp : 1;

        fileLoader::load('pager');
        // а может сделать модуль пейджер или например плагин для смарти?
        $pager = new pager('/news/list', $page, 1, $this->DAO->getCount());
        $this->smarty->assign('pager', $pager->toString());

        $this->response->setTitle('Новости -> Список');
        return $this->smarty->fetch('news.list.tpl');
    }
}

?>