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
 * faqDeleteController: контроллер для метода delete модуля faq
 *
 * @package modules
 * @subpackage faq
 * @version 0.1
 */

class faqDeleteController extends simpleController
{
    public function getView()
    {
        $faqMapper = $this->toolkit->getMapper('faq', 'faq');
        $id = $this->request->get('id', 'integer');

        $faq = $faqMapper->searchById($id);

        if ($faq) {
            $faqMapper->delete($faq->getId());
        }

        return jipTools::redirect();
    }
}

?>