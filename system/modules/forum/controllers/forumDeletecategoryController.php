<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * forumDeletecategoryController: контроллер для метода deletecategory модуля forum
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class forumDeletecategoryController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');
        $categoryMapper = $this->toolkit->getMapper('forum', 'category');

        $category = $categoryMapper->searchByKey($id);

        if ($category) {
            $categoryMapper->delete($category);
        }

        return jipTools::redirect();
    }
}

?>