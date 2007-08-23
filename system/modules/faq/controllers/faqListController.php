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
 * faqListController: контроллер для метода list модуля faq
 *
 * @package modules
 * @subpackage faq
 * @version 0.1
 */

class faqListController extends simpleController
{
    public function getView()
    {
        $name = $this->request->get('name', 'string');

        $categoryMapper = $this->toolkit->getMapper('faq', 'faqCategory');
        $category = $categoryMapper->searchByName($name);

        $this->smarty->assign('faqCategory', $category);
        return $this->smarty->fetch('faq/list.tpl');
    }
}

?>