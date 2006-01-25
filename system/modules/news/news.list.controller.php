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
        fileLoader::load("news/newsActiveRecord");
        fileLoader::load("news/newsTableModule");
        fileLoader::load("news/newsFolderActiveRecord");
        fileLoader::load("news/newsFolderTableModule");

    }

    public function getView()
    {
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();

        $newsFolders = new newsFolderTableModule($httprequest->getSection());

        //$params = $httprequest->getParams();
        if(($path = $httprequest->getParam(0)) == false) {
            $path = "/";
        }
        $folder = $newsFolders->searchByName($path);
        $data = $folder->getItems();
        return new newsListView($data);
    }
}

?>