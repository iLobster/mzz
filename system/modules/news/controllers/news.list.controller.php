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
 * NewsListController: контроллер для метода list модуля news
 *
 * @package news
 * @version 0.1
 */

class newsListController extends simpleController
{
    public function __construct()
    {
        fileLoader::load('news/views/news.list.view');
        fileLoader::load("news");
        fileLoader::load("news/newsFolder");
        fileLoader::load("news/mappers/newsMapper");
        fileLoader::load("news/mappers/newsFolderMapper");
        parent::__construct();
    }

    public function getView()
    {
        $newsFolderMapper = $this->toolkit->getCache(new newsFolderMapper($this->request->getSection()));

        if (($path = $this->request->get(0, SC_PATH)) == false) {
            $path = "root";
        }
        $newsFolder = $newsFolderMapper->searchByName($path);
        //echo'<pre>';print_r($newsFolder); echo'</pre>';
        //$newsFolder = new cache($newsFolder->searchByName($path), systemConfig::$pathToTemp . '/cache');
        // так делать нельзя - потому что результаты для $newsFolder->getItems() зависят не от аргументов а от маппера
        $data = $newsFolder->getItems();
        //echo'<pre>';print_r($data); echo'</pre>';
        return new newsListView($data, $newsFolderMapper);
    }
}

?>