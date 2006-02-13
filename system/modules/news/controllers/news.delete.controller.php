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
 * newsDeleteController: ���������� ��� ������ delete ������ news
 *
 * @package news
 * @version 0.1
 */

class newsDeleteController
{
    public function __construct()
    {
        fileLoader::load('news/views/news.delete.view');
        fileLoader::load("news");
        fileLoader::load("news/mappers/newsMapper");
    }

    public function getView()
    {
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();

        $newsMapper = new newsMapper($httprequest->getSection());
        $news = $newsMapper->create();
        $news->setId($httprequest->get(0, SC_PATH));
        $newsMapper->delete($news);
        $view = new newsDeleteView($news);

        return $view;
    }
}

?>
