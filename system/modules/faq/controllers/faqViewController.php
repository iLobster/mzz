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
 * faqViewController: контроллер для метода view модуля faq
 *
 * @package modules
 * @subpackage faq
 * @version 0.1
 */

class faqViewController extends simpleController
{
    public function getView()
    {
        $categoryMapper = $this->toolkit->getMapper('faq', 'faqCategory');

        $this->smarty->assign('categories', $categoryMapper->searchAll());
        return $this->smarty->fetch('faq/view.tpl');
    }
}

?>