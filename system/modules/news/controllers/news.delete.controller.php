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

class newsDeleteController extends simpleController
{
    public function __construct()
    {
        fileLoader::load('news/views/news.delete.view');
        fileLoader::load("news");
        fileLoader::load("news/mappers/newsMapper");
        parent::__construct();
    }

    public function getView()
    {
        $newsMapper = new newsMapper($this->request->getSection());
        $newsMapper->delete($this->request->get(0, SC_PATH));
        $view = new newsDeleteView();

        return $view;
    }
}

?>
