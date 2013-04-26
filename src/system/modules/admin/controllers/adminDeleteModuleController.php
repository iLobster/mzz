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
 * adminDeleteModuleController: контроллер для метода deleteModule модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.3
 */
class adminDeleteModuleController extends simpleController
{
    protected function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');

        $name = $this->request->getString('name');
        try {
            $module = $this->toolkit->getModule($name);
        } catch (mzzModuleNotFoundException $e) {
            return $this->forward404($adminMapper);
        }

        $adminGeneratorMapper = $this->toolkit->getMapper('admin', 'adminGenerator');

        try {
            $adminGeneratorMapper->deleteModule($module);
        } catch (Exception $e) {
            $controller = new messageController($this->getAction(), $e->getMessage(), messageController::WARNING);
            return $controller->run();
        }

        return jipTools::redirect();
    }
}

?>