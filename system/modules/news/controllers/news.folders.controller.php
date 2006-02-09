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
 * NewsViewController: ���������� ��� ������ list ������ news
 *
 * @package news
 * @version 0.1
 */

class newsFoldersController
{
    public function __construct()
    {
        fileLoader::load('news/views/news.folders.view');
        fileLoader::load("news/newsFolder");
        fileLoader::load("news/mappers/newsFolderMapper");
    }

    public function getView()
    {
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();

        $newsFolderMapper = new newsFolderMapper($httprequest->getSection());

        $folders = $newsFolderMapper->getFolders('');
        return new newsFoldersView($folders);
    }
}

?>
