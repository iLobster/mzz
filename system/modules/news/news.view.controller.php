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

class newsViewController
{
    public function __construct()
    {
        //fileLoader::load('news.view.model');
        fileLoader::load('news.view.view');
        fileLoader::load("news/newsActiveRecord");
        fileLoader::load("news/newsTableModule");
    }

    public function getView()
    {
        // ��� ����� ��� ������ �������� - �� ���� �� ����
        $registry = Registry::instance();
        $httprequest = $registry->getEntry('httprequest');
        $params = $httprequest->getParams();
        $tableModule = new newsTableModule();
        $news = $tableModule->getNews($params[0]);
        return new newsViewView($news);
    }
}

?>