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

fileLoader::load('codegenerator/directoryGenerator');

/**
 * adminDeleteModuleController: контроллер для метода deleteModule модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.2
 */

class adminDeleteModuleController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $adminGeneratorMapper = $this->toolkit->getMapper('admin', 'adminGenerator');
        $modules = $adminMapper->getModulesList();

        if (!isset($modules[$id])) {
            $controller = new messageController('Модуля не существует', messageController::WARNING);
            return $controller->run();
        }

        if (sizeof($modules[$id]['classes'])) {
            $controller = new messageController('Нельзя удалить модуль', messageController::WARNING);
            return $controller->run();
        }

        $dest = current($adminGeneratorMapper->getDests(true, $modules[$id]['name']));
        $dest = substr($dest, 0, strrpos($dest, DIRECTORY_SEPARATOR));

        $generator = new directoryGenerator($dest);
        try {
            $generator->delete($modules[$id]['name'], true);
            $generator->run();
        } catch (Exception $e) {
            $controller = new messageController('Во время удаления модуля произошла непредвиденная ошибка. Один из каталогов не может быть удалён: ' . $e->getMessage(), messageController::WARNING);
            return $controller->run();
        }

        $adminGeneratorMapper->deleteModule($id);

        $url = new url('default2');
        $url->setAction('devToolbar');
        return jipTools::redirect($url->get());
    }
}

?>