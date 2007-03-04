<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/codegenerator/templates/controller.tpl $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.tpl 1309 2007-02-13 05:54:09Z zerkms $
 */

/**
 * catalogueListController: контроллер для метода list модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */
 
class catalogueListController extends simpleController
{
    public function getView()
    {
        $catalogueFolderMapper = $this->toolkit->getMapper('catalogue', 'catalogueFolder');
        $path = $this->request->get('name', 'string', SC_PATH);
        
        $catalogueFolder = $catalogueFolderMapper->searchByPath($path);
        
        if (empty($catalogueFolder)) {
            return $catalogueFolderMapper->get404()->run();
        }
        
        $config = $this->toolkit->getConfig('catalogue');

        fileLoader::load('pager');
        $pager = new pager($this->request->getRequestUrl(), $this->getPageNumber(), $config->get('items_per_page'));

        $catalogueFolder->setPager($pager);
        $this->smarty->assign('folderPath', $catalogueFolder->getPath());
        $this->smarty->assign('pager', $pager);
        $this->smarty->assign('items', $catalogueFolder->getItems());
        $this->smarty->assign('catalogueFolder', $catalogueFolder);
        $catalogueFolder->removePager();
        
        return $this->smarty->fetch('catalogue/list.tpl');
    }
    
    private function getPageNumber()
    {
        return ($page = $this->request->get('page', 'integer', SC_GET)) > 0 ? $page : 1;
    }
}

?>