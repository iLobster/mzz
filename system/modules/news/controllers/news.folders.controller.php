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
 * NewsViewController: контроллер для метода list модуля news
 *
 * @package news
 * @version 0.1
 */

class newsFoldersController
{
    public function __construct()
    {
        fileLoader::load('news/view/news.folders.view');
        fileLoader::load("news/newsFolder");
        fileLoader::load("news/mappers/newsFolderMapper");
    }

    public function getFolders()
    {
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();

        $newsFolderMapper = new newsFolderMapper($httprequest->getSection());

        $folders = $newsFolderMapper->getFolders('0');
        return new newsFoldersView($folders);
    }
}

?>
