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
 * pageListController: контроллер для метода list модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */

fileLoader::load('page/views/pageListView');
fileLoader::load("page/mappers/pageMapper");

class pageListController extends simpleController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getView()
    {
        $pageMapper = $this->toolkit->getMapper('page', 'page', $this->request->getSection());

        $pages = $pageMapper->searchAll();
        if ($pages) {
            return new pageListView($pages);
        } else {
            fileLoader::load('news/views/page404View');
            return new page404View();
        }
    }
}

?>