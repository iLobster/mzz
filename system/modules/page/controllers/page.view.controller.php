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
 * pageViewController: контроллер для метода view модуля page
 *
 * @package page
 * @version 0.2
 */

fileLoader::load('cache');

class pageViewController
{
    public function __construct()
    {
        fileLoader::load('page/views/page.view.view');
        fileLoader::load("page");
        fileLoader::load("page/mappers/pageMapper");
    }

    public function getView($section = null)
    {
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();

        if (empty($section)) {
            $section = $httprequest->getSection();
        }

        $pageMapper = new pageMapper($section);

        if (($name = $httprequest->get(0, SC_PATH)) == false) {
            $name = 'main';
        }
        $page = $pageMapper->searchByName($name);
        return new pageViewView($page);
    }
}

?>
