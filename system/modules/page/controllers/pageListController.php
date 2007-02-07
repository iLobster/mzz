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
    public function getView()
    {
        $pageMapper = $this->toolkit->getMapper('page', 'page');

        $pages = $pageMapper->searchAll();
        if ($pages) {
            $this->smarty->assign('pages', $pages);
            $this->response->setTitle('Страницы -> Список');
            return $this->smarty->fetch('page/list.tpl');
        } else {
            fileLoader::load('news/views/page404View');
            return new page404View();
        }
    }
}

?>