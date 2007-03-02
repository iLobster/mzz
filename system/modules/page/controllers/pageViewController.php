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
 * pageViewController: контроллер дл€ метода view модул€ page
 *
 * @package modules
 * @subpackage page
 * @version 0.2.1
 */

class pageViewController extends simpleController
{
    public function getView()
    {
        if (($name = $this->request->get('name', 'string', SC_PATH)) == false) {
            if (($name = $this->request->get('id', 'string', SC_PATH)) == false) {
                $name = 'main';
            }
        }

        $pageFolderMapper = $this->toolkit->getMapper('page', 'pageFolder');
        $page = $pageFolderMapper->searchChild($name);

        if (empty($page)) {
            return $pageFolderMapper->get404()->run();
        }

        $this->smarty->assign('page', $page);
        $this->response->setTitle('—траницы -> ' . $page->getTitle());
        return $this->smarty->fetch('page/view.tpl');
    }
}

?>