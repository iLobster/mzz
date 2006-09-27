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
 * newsDeleteController: контроллер для метода delete модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */

class newsDeleteController extends simpleController
{
    public function __construct()
    {
        fileLoader::load('news/views/newsDeleteView');
        fileLoader::load("news/mappers/newsMapper");
        parent::__construct();
    }

    public function getView()
    {
        $newsMapper = new newsMapper($this->request->getSection());
        $newsMapper->delete($this->request->get(0, 'integer', SC_PATH));
        $view = new newsDeleteView();

        return $view;
    }
}

?>
