<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * smarty_function_load: функция для смарти, загрузчик модулей
 *
 * Примеры использования:<br />
 * {load module="some_module_name" action="some_action"}
 *
 * @param array $params входные аргументы функции
 * @param object $smarty объект смарти
 * @return string результат работы модуля
 * @package system
 * @version 0.3
 */
function smarty_function_load($params, $smarty) {
    if(!isset($params['module'])) {
        $error = "Template error. Module is not specified.";
        throw new mzzRuntimeException($error);
    }
    $module = $params['module'];
    $modulename = $module . 'Factory';
    $action_name = $params['action'];

    fileLoader::load($module . '.factory');
    $toolkit = systemToolkit::getInstance();
    $action = $toolkit->getAction($params['module']);
    $action->setAction($action_name);
    $factory = new $modulename($action);
    $controller = $factory->getController();
    $view = $controller->getView();
    $result = $view->toString();
    return $result;
}

?>