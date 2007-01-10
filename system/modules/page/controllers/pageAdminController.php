<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
*/

fileLoader::load('page/views/pageAdminView');

/**
 * pageAdminController: контроллер для метода admin модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */
class pageAdminController extends simpleController
{
    public function getView()
    {
        $pageFolderMapper = $this->toolkit->getMapper('page', 'pageFolder');

        $path = $this->request->get('params', 'string', SC_PATH);

        if (is_null($path)) {
            $path = 'root';
        }

        $pageFolder = $pageFolderMapper->searchByPath($path);
        if ($pageFolder) {
            return new pageAdminView($pageFolder);
        } else {
            fileLoader::load('news/views/news404View');
            return new news404View();
        }
    }
}

?>