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

class newsListController
{
    public function __construct()
    {
        fileResolver::includer('news','news.list.model');
        fileResolver::includer('news','news.list.view');
    }
    
    public function getView()
    {
        // ��� ����� ��� ������ �������� - �� ���� �� ����
        return new newsListView(new newsListModel());
    }
}

?>