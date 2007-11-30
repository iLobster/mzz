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
 * faqAdminController: контроллер для метода admin модуля faq
 *
 * @package modules
 * @subpackage faq
 * @version 0.1
 */

class faqAdminController extends simpleController
{
    public function getView()
    {
        $folderMapper = $this->toolkit->getMapper('faq', 'faqFolder');
        $categoryMapper = $this->toolkit->getMapper('faq', 'faqCategory');

        $categories = $categoryMapper->searchAll();

        $this->smarty->assign('categories', $categories);
        $this->smarty->assign('folder', $folderMapper->getFolder());
        return $this->smarty->fetch('faq/admin.tpl');
    }
}

?>