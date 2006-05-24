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

class pageDeleteController extends simpleController
{
    public function __construct()
    {
        fileLoader::load('page/views/page.delete.view');
        fileLoader::load("page");
        fileLoader::load("page/mappers/pageMapper");
        parent::__construct();
    }

    public function getView()
    {
        $pageMapper = new pageMapper($this->request->getSection());
        $page = $pageMapper->create();
        $page->setName($this->request->get(0, SC_PATH));
        $pageMapper->delete($page);
        $view = new pageDeleteView($page);

        return $view;
    }
}

?>
