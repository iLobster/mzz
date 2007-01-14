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

fileLoader::load('page/views/pageDeleteView');
fileLoader::load("page/mappers/pageMapper");

class pageDeleteController extends simpleController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getView()
    {
        $pageMapper = $this->toolkit->getMapper('page', 'page', $this->request->getSection());

        $page = $pageMapper->searchByName($this->request->get('name', 'string', SC_PATH));

        if ($page) {
            $pageMapper->delete($page->getId());
            return new pageDeleteView();
        } else {
            fileLoader::load('page/views/page404View');
            return new page404View();
        }
    }
}

?>