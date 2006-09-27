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
 * @package modules
 * @subpackage page
 * @version 0.2
 */

class pageViewController extends simpleController
{
    public function __construct()
    {
        fileLoader::load('page/views/pageViewView');
        fileLoader::load("page");
        fileLoader::load("page/mappers/pageMapper");
        parent::__construct();
    }

    public function getView()
    {
        $section = $this->request->getSection();

        //$pageMapper = $this->toolkit->getCache(new pageMapper($section));
        $pageMapper = new pageMapper($section);

        //$pageMapper = new pageMapper($section);

        if (($name = $this->request->get(0, 'string', SC_PATH)) == false) {
            $name = 'main';
        }
        $page = $pageMapper->searchByName($name);
        if ($page) {
            return new pageViewView($page);
        } else {
            fileLoader::load('page/views/page404View');
            return new page404View();
        }
    }
}

?>
