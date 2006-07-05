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
 * @package system
 * @subpackage template
 * @version $Id$
*/

/**
 * smarty_function_load: функция для смарти, загрузчик модулей
 *
 * Примеры использования:<br />
 * <code>
 * {load module="some_module_name" action="some_action"}
 * </code>
 *
 * @param array $params входные аргументы функции
 * @param object $smarty объект смарти
 * @return string результат работы модуля
 * @package system
 * @subpackage template
 * @version 0.3.1
 */
function smarty_function_load($params, $smarty)
{
    if (!isset($params['module'])) {
        $error = "Template error. Module is not specified.";
        throw new mzzRuntimeException($error);
    }

    $module = $params['module'];
    $modulename = $module . 'Factory';
    $action_name = $params['action'];

    fileLoader::load($module . '.factory');
    $toolkit = systemToolkit::getInstance();

    $oldRequest = clone $toolkit->getRequest();

    $action = $toolkit->getAction($params['module']);
    $action->setAction($action_name);

    if(isset($params['args'])) {
        $toolkit->getRequest()->setParams(explode('/', $params['args']));
    }

    $section = (isset($params['section'])) ? $params['section'] : null;

    $factory = new $modulename($action);

    $controller = $factory->getController();

    $view = $controller->getView($section);

    $result = $view->toString();

    $toolkit->setRequest($oldRequest);
    return $result;
}

?>