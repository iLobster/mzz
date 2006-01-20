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
        //fileLoader::load('news.view.model');
        fileLoader::load('news.view.view');
        fileLoader::load("news/newsActiveRecord");
        fileLoader::load("news/newsTableModule");
    }

    public function getView()
    {
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();
        $params = $httprequest->getParams();

        $tableModule = new newsTableModule($httprequest->getSection());
        $news = $tableModule->searchById($params[0]);
        return new newsViewView($news);
    }
}

?>