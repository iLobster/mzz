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

fileLoader::load('news/views/newsListView');
fileLoader::load("news/mappers/newsMapper");
fileLoader::load("news/mappers/newsFolderMapper");

class newsListController extends simpleController
{
    public function getView()
    {
        $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder', $this->request->getSection());

        $path = $this->request->get('name', 'string', SC_PATH);

        $newsFolder = $newsFolderMapper->searchByPath($path);
        if ($newsFolder) {
            return new newsListView($newsFolder, $newsFolder);
        } else {
            fileLoader::load('news/views/news404View');
            return new news404View();
        }
    }
}
?>