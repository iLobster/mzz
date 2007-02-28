<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * pageDeleteController: контроллер для метода delete модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.1.2
 */
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

            return jipTools::redirect();
        } else {
            fileLoader::load('page/views/page404View');
            return new page404View();
        }
    }
}

?>