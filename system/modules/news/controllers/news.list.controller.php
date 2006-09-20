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
 * @package modules
 * @subpackage news
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
        $newsFolderMapper = new newsFolderMapper($this->request->getSection());

        $path = $this->request->get(0, 'string', SC_PATH);

        $newsFolder = $newsFolderMapper->searchByName($path);
        if ($newsFolder) {
            return new newsListView($newsFolder, $newsFolderMapper);
        } else {
            fileLoader::load('news/views/news.404.view');
            return new news404View();
        }
    }
}

?>