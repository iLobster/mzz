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
 * @package modules
 * @subpackage news
 * @version 0.2
 */

class newsListView extends simpleView
{
    protected $newsFolderMapper;
    private $config;

    public function __construct($news)
    {
        parent::__construct($news);
        $this->config = $this->toolkit->getConfig($this->httprequest->getSection(), 'news');
    }

    public function toString()
    {
        fileLoader::load('pager');

        $page = ($this->getPageFromRequest() > 0) ? $this->getPageFromRequest() : 1;

        $pager = new pager($this->httprequest->getUrl(), $page, $this->config->get('items_per_page'));

        $this->DAO->setPager($pager);
        $this->smarty->assign('folderPath', $this->DAO->getPath());
        $this->smarty->assign('pager', $pager);
        $this->smarty->assign('news', $this->DAO->getItems());
        $this->smarty->assign('newsFolder', $this->DAO);

        $this->DAO->removePager();

        $this->response->setTitle('Новости -> Список');

        return $this->smarty->fetch('news.list.tpl');
    }

    private function getPageFromRequest()
    {
        return $this->httprequest->get('page', 'integer', SC_GET);
    }
}

?>