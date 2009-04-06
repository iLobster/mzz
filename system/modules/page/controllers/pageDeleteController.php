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
    protected function getView()
    {
        $name = $this->request->getString('name');

        $pageMapper = $this->toolkit->getMapper('page', 'page');
        $pageFolderMapper = $this->toolkit->getMapper('page', 'pageFolder');
        $page = $pageFolderMapper->searchChild($name);

        if (empty($page)) {
            return $this->forward404($pageMapper);
        }

        $pageMapper->delete($page);
        return jipTools::redirect();
    }
}

?>