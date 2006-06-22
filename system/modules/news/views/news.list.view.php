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
    private $httprequest;

    public function __construct($news, $newsFolderMapper)
    {
        $this->newsFolderMapper = $newsFolderMapper;
        parent::__construct($news);

        $toolkit = systemToolkit::getInstance();
        $this->httprequest = $toolkit->getRequest();
    }

    public function toString()
    {
        fileLoader::load('pager');

        $page = ($this->getPageFromRequest() > 0) ? $this->getPageFromRequest() : 1;

        $pager = new pager('/' . $this->httprequest->getSection() . '/' . $this->DAO->getName() . '/list', $page, 1);

        $this->DAO->setPager($pager);

        $this->smarty->assign('folderPath', $this->DAO->getName());

        $this->smarty->assign('pager', $pager);

        $this->response->setTitle('Новости -> Список');

        $this->smarty->assign('news', $this->DAO->getItems());
        $this->smarty->assign('newsFolder', $this->newsFolderMapper);

        return $this->smarty->fetch('news.list.tpl');
    }

    private function getPageFromRequest()
    {
        return $this->httprequest->get('page', SC_GET);
    }
}

?>