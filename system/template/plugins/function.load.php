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

fileLoader::load('acl');

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
 * @version 0.3.2
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

    $action = $toolkit->getAction($params['module']);
    $action->setAction($action_name);

    $request = $toolkit->getRequest();
    $request->save();

    if(isset($params['section'])) {
        $request->setSection($params['section']);
    }

    if(isset($params['args'])) {
        $request->setParams(explode('/', $params['args']));
    }

    // хм, а почему null а не $request->getSection() например??
    $section = (isset($params['section'])) ? $params['section'] : null;

    $mappername = $action->getType() . 'Mapper';

    fileLoader::load($module . '/mappers/' . $mappername);

    $mapper = new $mappername($request->getSection());
    $object_id = $mapper->convertArgsToId($request->getParams());

    $user = $toolkit->getUser();

    $acl = new acl($module, $request->getSection(), $user, $object_id);

    if ($acl->get($action->getActionName()))
        echo 'есть доступ';
    else
        echo 'нет доступа';

    $factory = new $modulename($action);

    $controller = $factory->getController();

    $view = $controller->getView($section);

    $result = $view->toString();

    if(isset($request)) {
        $request->restore();
    }

    return $result;
}

?>