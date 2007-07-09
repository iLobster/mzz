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
 * simple403Controller: контроллер для метода 403 модуля simple
 *
 * @package modules
 * @subpackage simple
 * @version 0.1
 */

class simple403Controller extends simpleController
{
    public function getView()
    {
        $this->request->setSection('page');
        $this->request->setParams(array('name' => '403'));
        $this->request->setAction('view');

        $action = $this->toolkit->getAction('page');
        $action->setAction('view');

        fileLoader::load('pageFactory');

        $factory = new pageFactory($action);
        $controller = $factory->getController();

        $this->toolkit->getResponse()->setHeader('', 'HTTP/1.x 403 Forbidden');

        return $controller->run();
    }
}

?>