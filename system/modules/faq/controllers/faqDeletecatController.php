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
 * faqDeletecatController: контроллер для метода deletecat модуля faq
 *
 * @package modules
 * @subpackage faq
 * @version 0.1
 */

class faqDeletecatController extends simpleController
{
    public function getView()
    {
        $faqCategoryMapper = $this->toolkit->getMapper('faq', 'faqCategory');
        $name = $this->request->getString('name');

        $category = $faqCategoryMapper->searchByName($name);

        if ($category) {
            $faqCategoryMapper->delete($category);
        }

        return jipTools::redirect();
    }
}

?>