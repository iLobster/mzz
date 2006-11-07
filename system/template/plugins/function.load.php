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
    unset($params['module']);

    $modulename = $module . 'Factory';

    fileLoader::load($module . 'Factory');
    $toolkit = systemToolkit::getInstance();

    $action = $toolkit->getAction($module);
    $action->setAction($params['action']);
    unset($params['action']);

    $request = $toolkit->getRequest();
    $request->save();

    if(!empty($params['section'])) {
        $request->setSection($params['section']);
        unset($params['section']);
    }

    foreach ($params as $name => $value) {
        $request->setParam($name, $value);
    }

    /* @todo убрать */
    if (isset($params['args'])) {
        $request->setParams(explode('/', $params['args']));
    }

    $mappername = $action->getType() . 'Mapper';
    $mapper = $toolkit->getMapper($module, $action->getType(), $request->getSection());

    $object_id = $mapper->convertArgsToId($request->getParams());
    $acl = new acl($toolkit->getUser(), $object_id);

    $actionName = $action->getActionName();

    $aclActions = array('editUser', 'addUser', 'editGroup', 'addGroup');
    if (in_array($actionName, $aclActions)) {
        $actionName = 'editACL';
    } else {
        $aclDefaultActions = array('editOwner', 'editUserDefault', 'editGroupDefault');
        if (in_array($actionName, $aclDefaultActions)) {
            $actionName = 'editDefault';
        }
    }

    $access = $acl->get($actionName);

    $result = '';

    if ($access) {
        $factory = new $modulename($action);
    } else {
        $request->setSection('page');
        $request->setParams(array('name' => '403'));
        $request->setAction('view');

        $action = $toolkit->getAction('page');
        $action->setAction('view');

        fileLoader::load('pageFactory');

        $factory = new pageFactory($action);
    }

    $controller = $factory->getController();
    $view = $controller->getView();

    $request->restore();

    return $view->toString();
}

?>
