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
 * votingDeleteCategoryController: контроллер для метода deletecategory модуля voting
 *
 * @package modules
 * @subpackage voting
 * @version 0.1
 */

class votingDeleteCategoryController extends simpleController
{
    public function getView()
    {
        $id = $this->request->getInteger('id');
        $categoryMapper = $this->toolkit->getMapper('voting', 'voteCategory');

        $category = $categoryMapper->searchById($id);

        if ($category) {
            $categoryMapper->delete($category);
        }

        return jipTools::redirect();
    }
}

?>