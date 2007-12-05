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
 * adminDeleteCfgController: контроллер для метода deleteCfg модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.1
 */

class adminDeleteCfgController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->get('id', 'integer', SC_PATH);
        $configMapper = $this->toolkit->getMapper('config', 'config', 'config');
        $configMapper->deleteProperty($id);

        return jipTools::closeWindow();
    }
}

?>