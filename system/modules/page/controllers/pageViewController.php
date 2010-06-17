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
 * pageViewController: контроллер для метода view модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.2.1
 */

class pageViewController extends simpleController
{
    protected function getView()
    {
        $name = $this->request->getString('name');
        if (!$name) {
            $name = $this->request->getString('id');
        }
        $pageMapper = $this->toolkit->getMapper('page', 'page');

        $page = $pageMapper->searchByName($name);

        if (empty($page)) {
            return $this->forward404($pageMapper);
        }

        $this->view->assign('page', $page);
        return $this->render('page/view.tpl');
    }
}

?>