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
 * @package modules
 * @subpackage news
 * @version 0.1
 */

fileLoader::load('news/views/newsListView');
fileLoader::load("news/mappers/newsMapper");
fileLoader::load("news/mappers/newsFolderMapper");

class newsListController extends simpleController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getView()
    {
        $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder', $this->request->getSection());

        $path = $this->request->get(0, 'string', SC_PATH);

        $newsFolder = $newsFolderMapper->searchByName($path);
        if ($newsFolder) {
            return new newsListView($newsFolder, $newsFolderMapper);
        } else {
            fileLoader::load('news/views/news404View');
            return new news404View();
        }
    }
}

?>