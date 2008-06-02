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
 * pageListController: контроллер для метода list модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */
class pageListController extends simpleController
{
    protected function getView()
    {
        $pageMapper = $this->toolkit->getMapper('page', 'page');

        $pages = $pageMapper->searchAll();
        if (empty($pages)) {
            return $pageMapper->get404()->run();
        }

        $this->smarty->assign('pages', $pages);
        return $this->smarty->fetch('page/list.tpl');
    }
}

?>