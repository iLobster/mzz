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
 * simple403Controller: контроллер страницы с 403 ошибкой
 *
 * @package modules
 * @subpackage simple
 * @version 0.1.2
 */
class simple403Controller extends simpleController
{
    public function getView()
    {
        $this->response->setStatus(403);

        try {
            $module = $this->action->getModuleName();
            $class = $this->action->getClassName();
            $controller = $class . '403Controller';
            fileLoader::load($module . '/controllers/' . $controller);
            $controller = new $controller($this->action);
            return $controller->run();
        } catch (mzzIoException $e) {
        }

        return $this->view->render('simple/403.tpl');
    }
}
?>