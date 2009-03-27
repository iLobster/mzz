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
 * newsListController: контроллер для метода list модуля news
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
        $path = $this->request->getString('name');
        $newsFolder = $newsFolderMapper->searchByPath($path);

        if (empty($newsFolder)) {
            return $this->forward404($newsFolderMapper);
        }

        $config = $this->toolkit->getConfig('news');
        $this->setPager($newsFolderMapper, $config->get('items_per_page'), true);

        $this->smarty->assign('news', $newsFolderMapper->getItems($newsFolder));
        $this->smarty->assign('folderPath', $newsFolder->getTreePath());
        $this->smarty->assign('rootFolder', $newsFolderMapper->searchByPath('root'));
        $this->smarty->assign('newsFolder', $newsFolder);

        return $this->smarty->fetch('news/list.tpl');
    }
}

?>