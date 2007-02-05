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
 * pageDeleteController: ���������� ��� ������ delete ������ page
 *
 * @package modules
 * @subpackage page
 * @version 0.1.2
 */

fileLoader::load('page/views/pageDeleteView');
fileLoader::load("page/mappers/pageMapper");

class pageDeleteController extends simpleController
{
    public function getView()
    {
        if (($name = $this->request->get('name', 'string', SC_PATH)) == false) {
            if (($name = $this->request->get('id', 'string', SC_PATH)) == false) {
                $name = 'main';
            }
        }

        $pageMapper = $this->toolkit->getMapper('page', 'page');
        $pageFolderMapper = $this->toolkit->getMapper('page', 'pageFolder');
        $page = $pageFolderMapper->searchChild($name);

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