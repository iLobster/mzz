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
 * @version 0.2
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
        if ($this->DAO) {
            fileLoader::load('pager');

            $page = ($this->getPageFromRequest() > 0) ? $this->getPageFromRequest() : 1;

            // последний аргумент - число новостей на страницу - получить его из конфига
            $pager = new pager($this->httprequest->getUrl(), $page, 1);

            $this->DAO->setPager($pager);

            $this->smarty->assign('folderPath', $this->DAO->getName());
            $this->smarty->assign('pager', $pager);
            $this->smarty->assign('news', $this->DAO->getItems());
            $this->smarty->assign('newsFolderMapper', $this->newsFolderMapper);

            $this->response->setTitle('Новости -> Список');

            return $this->smarty->fetch('news.list.tpl');
        } else {
            $this->response->setTitle('Папка отсутствует');
            return $this->smarty->fetch('news.notfound.tpl');
        }
    }

    private function getPageFromRequest()
    {
        return $this->httprequest->get('page', SC_GET);
    }
}

?>