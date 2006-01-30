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

class newsListController
{
    public function __construct()
    {
        //fileLoader::load('news.list.model');
        fileLoader::load('news.list.view');
        //fileLoader::load("news/newsActiveRecord");
        //fileLoader::load("news/newsTableModule");
        //fileLoader::load("news/newsFolderActiveRecord");
        //fileLoader::load("news/newsFolderTableModule");

        fileLoader::load("news");
        fileLoader::load("news/newsFolder");
        fileLoader::load("news/newsMapper");
        fileLoader::load("news/newsFolderMapper");


    }

    public function getView()
    {
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();

        $newsFolder = new newsFolderMapper($httprequest->getSection());

        //$params = $httprequest->getParams();
        if(($path = $httprequest->get(0, SC_PATH)) == false) {
            $path = "/";
        }
        $folder = $newsFolder->searchByName($path);
        $data = $folder->getItems($newsFolder);
        return new newsListView($data);
    }
}

?>