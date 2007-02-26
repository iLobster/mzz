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
 * @version 0.4.2
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

    $access = true;

    if (!isset($params['403handle']) || $params['403handle'] != 'none') {

        $mappername = $action->getType() . 'Mapper';
        $mapper = $toolkit->getMapper($module, $action->getType(), $request->getSection());

        try {
            $object_id = $mapper->convertArgsToId($request->getParams());

            $acl = new acl($toolkit->getUser(), $object_id);

            $actionName = $action->getActionName(true);

            //var_dump($actionName); var_dump($object_id);

            $access = $acl->get($actionName);

        } catch (mzzDONotFoundException $e) {
            $controller = $mapper->get404();
        }
    }

    if (isset($params['403handle']) && $params['403handle'] == 'manual') {
        $request->setParam('access', $access);
        $access = true;
    }

    if ($access) {
        $factory = new $modulename($action);
    } else {
        if (!isset($params['403tpl'])) {
            $request->setSection('page');
            $request->setParams(array('name' => '403'));
            $request->setAction('view');

            $action = $toolkit->getAction('page');
            $action->setAction('view');

            fileLoader::load('pageFactory');

            $factory = new pageFactory($action);
        } else {
            $smarty = $toolkit->getSmarty();
            return $smarty->fetch($params['403tpl']);
        }
    }

    if (!isset($controller)) {
        $controller = $factory->getController();
    }

    $view = $controller->getView();

    if ($view instanceof simpleView) {
        $output = $view->toString();
    } else {
        $output = $view;
    }

    $request->restore();
    return $output;
}

?>