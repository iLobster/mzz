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
 * pageDeleteController: контроллер для метода delete модуля page
 *
 * @package page
 * @version 0.1
 */

class pageDeleteController
{
    public function __construct()
    {
        fileLoader::load('page/views/page.delete.view');
        fileLoader::load("page");
        fileLoader::load("page/mappers/pageMapper");
    }

    public function getView()
    {
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();

        $pageMapper = new pageMapper($httprequest->getSection());
        $page = $pageMapper->create();
        $page->setName($httprequest->get(0, SC_PATH));
        $pageMapper->delete($page);
        $view = new pageDeleteView($page);

        return $view;
    }
}

?>
