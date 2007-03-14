<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
*/

/**
 * newsAdminController: ���������� ��� ������ admin ������ news
 *
 * @package modules
 * @subpackage news
 * @version 0.1.1
 */

class newsAdminController extends simpleController
{
    public function getView()
    {
        $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder');

        $path = $this->request->get('params', 'string', SC_PATH);

        if (is_null($path)) {
            $path = 'root';
        }

        $newsFolder = $newsFolderMapper->searchByPath($path);
        if (empty($newsFolder)) {
            return $newsFolderMapper->get404()->run();
        }

        $breadCrumbs = $newsFolderMapper->getPath($newsFolder);

        $this->smarty->assign('section_name', $this->request->get('section_name', 'string', SC_PATH));
        $this->smarty->assign('news', $newsFolder->getItems());
        $this->smarty->assign('newsFolder', $newsFolder);
        $this->smarty->assign('breadCrumbs', $breadCrumbs);
        return $this->smarty->fetch('news/admin.tpl');
    }
}

?>