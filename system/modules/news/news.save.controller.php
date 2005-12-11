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

class newsEditController
{
    public function __construct()
    {
        fileLoader::load('news.edit.model');
        fileLoader::load('news.edit.view');
    }
    
    public function getView()
    {
        // ��� ����� ��� ������ �������� - �� ���� �� ����
        return new newsEditView(new newsEditModel());
    }
}

?>