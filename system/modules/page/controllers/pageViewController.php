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

fileLoader::load('page/views/pageViewView');
fileLoader::load("page/mappers/pageMapper");

class pageViewController extends simpleController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getView()
    {
        $section = $this->request->getSection();

        $pageMapper = $this->toolkit->getMapper('page', 'page', $this->request->getSection());

        if (($name = $this->request->get('name', 'string', SC_PATH)) == false) {
            if (($name = $this->request->get('id', 'string', SC_PATH)) == false) {
                $name = 'main';
            }
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
