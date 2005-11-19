<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2005
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
        /*
        fileResolver::includer('news','news.view.model');
        fileResolver::includer('news','news.view.view');*/
        fileLoader::load('news.view.model');
        fileLoader::load('news.view.view');
    }
    
    public function getView()
    {
        // ��� ����� ��� ������ �������� - �� ���� �� ����
        return new newsViewView(new newsViewModel());
    }
}

?>