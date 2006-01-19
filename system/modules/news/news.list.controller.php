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
        // ��� ����� ��� ������ �������� - �� ���� �� ����

        $registry = Registry::instance();
        $newsFolders = new newsFolderTableModule();

        $httprequest = $registry->getEntry('httprequest');
        $params = $httprequest->getParams();
        if(!isset($params[0])) {
            $params[0] = "/";
        }
        $folder = $newsFolders->searchByName($params[0]);
        $data = $folder->getItems();
        return new newsListView($data);
    }
}

?>