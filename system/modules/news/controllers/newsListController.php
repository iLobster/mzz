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
 * newsListController: ���������� ��� ������ list ������ news
 *
 * @package modules
 * @subpackage news
 * @version 0.1.2
 */

class newsListController extends simpleController
{
    protected function getView()
    {
        $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder');
        $path = $this->request->get('name', 'string', SC_PATH);
        $newsFolder = $newsFolderMapper->searchByPath($path);

        if (empty($newsFolder)) {
            return $newsFolderMapper->get404()->run();
        }

        $config = $this->toolkit->getConfig('news');
        $this->setPager($newsFolder, $config->get('items_per_page'), true);

        $this->smarty->assign('news', $newsFolder->getItems());
        $this->smarty->assign('folderPath', $newsFolder->getPath());
        $this->smarty->assign('newsFolder', $newsFolder);

        return $this->smarty->fetch('news/list.tpl');
    }
}

?>