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
 *
 * @package system
 * @subpackage template
 * @version 0.4
 */
function smarty_function_load($params, $smarty)
{
    if (!isset($params['module'])) {
        $error = "Template error. Module is not specified.";
        throw new mzzRuntimeException($error);
    }

    $module = $params['module'];
    $modulename = $module . 'Factory';

    fileLoader::load($module . 'Factory');
    $toolkit = systemToolkit::getInstance();

    $action = $toolkit->getAction($params['module']);
    $action->setAction($params['action']);

    $request = $toolkit->getRequest();
    $request->save();

    if(isset($params['args'])) {
        $section = $request->getSection();
        $request->setParams(explode('/', $params['args']));
        $request->setSection($section);
    }

    if(!empty($params['section'])) {
        $request->setSection($params['section']);
    }

    $mappername = $action->getType() . 'Mapper';
    $mapper = $toolkit->getMapper($module, $action->getType(), $request->getSection());

    $object_id = $mapper->convertArgsToId($request->getParams());

    $acl = new acl($toolkit->getUser(), $object_id);

    $actionName = $action->getActionName();

    $aclActions = array('editUser', 'addUser', 'editGroup', 'addGroup');
    if (in_array($actionName, $aclActions)) {
        $actionName = 'editACL';
    }

    $access = $acl->get($actionName);

    $result = '';

    if ($access) {

        $factory = new $modulename($action);
        $controller = $factory->getController();
        $view = $controller->getView();

        if(!isset($_REQUEST['xajax'])) {
            $result = $view->toString();
        }
    } else {
        $result = 'нет доступа. Модуль <b>' . $module . ' </b>, экшн <b>' . $actionName . '</b>, obj_id <b>' . $object_id . '</b>';
    }

    $request->restore();

    return $result;
}

?>
