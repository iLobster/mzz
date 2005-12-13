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
    }

    public function getView()
    {
        // ��� ����� ��� ������ �������� - �� ���� �� ����
        return new newsListView(new newsTableModule());
    }
}

?>