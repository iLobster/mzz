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
 * @package modules
 * @subpackage page
 * @version 0.1.1
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
        $page = $pageMapper->searchByName($this->request->get(0, 'string', SC_PATH));

        if ($page) {
            $pageMapper->delete($page->getId());
            return new pageDeleteView();
        } else {
            fileLoader::load('page/views/page.404.view');
            return new page404View();
        }
    }
}

?>
