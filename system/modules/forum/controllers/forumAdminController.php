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
 * forumAdminController: контроллер для метода admin модуля forum
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class forumAdminController extends simpleController
{
    public function getView()
    {
        $categoryMapper = $this->toolkit->getMapper('forum', 'category');
        $categories = $categoryMapper->searchAll();

        $this->smarty->assign('categories', $categories);
        return $this->smarty->fetch('forum/admin.tpl');
    }
}

?>