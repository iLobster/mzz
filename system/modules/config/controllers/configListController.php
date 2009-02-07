<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * configListController: контроллер для метода list модуля config
 *
 * @package modules
 * @subpackage config
 * @version 0.1
 */

class configListController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');
        $configFolderMapper = $this->toolkit->getMapper('config', 'configFolder');

        $configFolder = $configFolderMapper->searchById($id);
        if (!$configFolder) {
            return $this->forward404($configFolderMapper);
        }

        $this->smarty->assign('folder', $configFolder);
        $this->smarty->assign('options', $configFolder->getOptions());
        return $this->smarty->fetch('config/list.tpl');
    }
}

?>