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
 * NewsListController: ���������� ��� ������ list ������ news
 *
 * @package news
 * @version 0.1
 */

fileLoader::load('cache');

class newsListController
{
    public function __construct()
    {
        fileLoader::load('news/views/news.list.view');
        fileLoader::load("news");
        fileLoader::load("news/newsFolder");
        fileLoader::load("news/mappers/newsMapper");
        fileLoader::load("news/mappers/newsFolderMapper");
    }

    public function getView()
    {
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();

        $newsFolder = new cache(new newsFolderMapper($httprequest->getSection()), systemConfig::$pathToTemp . '/cache');

        if (($path = $httprequest->get(0, SC_PATH)) == false) {
            $path = "root";
        }
        $folder = $newsFolder->searchByName($path);
        $data = $folder->getItems($newsFolder);
        return new newsListView($data, $newsFolder);
    }
}

?>