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
 * NewsViewController: контроллер для метода list модуля news
 *
 * @package news
 * @version 0.1
 */

class newsViewController
{
    public function __construct()
    {
        fileLoader::load('news/views/news.view.view');
        fileLoader::load("news");
        fileLoader::load("news/mappers/newsMapper");
    }

    public function getView()
    {
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();

        $newsMapper = new newsMapper($httprequest->getSection());

        if(($id = $httprequest->get(0, SC_PATH)) == false) {
            $id = 0;
        }
        $news = $newsMapper->searchById($id);
        return new newsViewView($news);
    }
}

?>
