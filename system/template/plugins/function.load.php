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
fileLoader::load('service/sideHelper');

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
 * @version 0.4.7
 */
function smarty_function_load($params, $smarty)
{
    if (!isset($params['module'])) {
        $error = "Template error. Module is not specified.";
        throw new mzzRuntimeException($error);
    }

    $side = sideHelper::getInstance();
    if (isset($params['_side']) && $side->isHidden($params['module'] . '_' . $params['action'])) {
        return null;
    }

    // получаем необходимые для запуска модуля и аутентификации данные
    $module = $params['module'];
    unset($params['module']);

    $toolkit = systemToolkit::getInstance();

    $action = $toolkit->getAction($module);
    $action->setAction($params['action']);
    unset($params['action']);

    $request = $toolkit->getRequest();
    $request->save();

    $request->setAction($action->getActionName());

    if(!empty($params['section'])) {
        $request->setSection($params['section']);
        unset($params['section']);
    }

    foreach ($params as $name => $value) {
        $request->setParam($name, $value);
    }

    $access = true;
    $actionConfig = $action->getAction();

    // проверяем - не отключена ли в данном запуске модуля проверка прав
    if (!isset($actionConfig['403handle']) || $actionConfig['403handle'] != 'none') {

        $mappername = $action->getType() . 'Mapper';
        $mapper = $toolkit->getMapper($module, $action->getType(), $request->getSection());

        try {
            $args = $request->getParams();

            $actionName = $action->getActionName(true);

            if (isset($args['section_name']) && isset($args['module_name']) && $actionName == 'admin') {
                $mapper = $toolkit->getMapper('admin', 'admin', $request->getSection());
            }

            //$object_id = $mapper->convertArgsToId($args);
            $obj = $mapper->convertArgsToObj($args);
            //$object_id = $obj->getObjId();
            //$acl = new acl($toolkit->getUser(), $object_id);

            //var_dump($actionName, $obj->getObjId());

            //$access = $acl->get($actionName);
            $access = $obj->getAcl($actionName);

        } catch (mzzDONotFoundException $e) {
            $controller = $mapper->get404();
        }
    }

    // проверяем, включен ли ручной режим проверки прав
    if (isset($actionConfig['403handle']) && $actionConfig['403handle'] == 'manual') {
        $request->setParam('access', $access);
        $access = true;
    }

    if ($access) {
        // если права на запуск модуля есть - запускаем
        $factory = new simpleFactory($action, $module);
        $controller = $factory->getController();
    } else {
        // если прав нет - запускаем либо стандартное сообщение о 403 ошибке, либо пользовательское
        if (!isset($params['403tpl'])) {
            fileLoader::load('simple/simple403Controller');
            $controller = new simple403Controller();
        } else {
            $smarty = $toolkit->getSmarty();
            $view = $smarty->fetch($params['403tpl']);
            $request->restore();

            if (!empty($params['403header'])) {
                $toolkit->getResponse()->setStatus(403);
            }
        }
    }

    if ($controller) {
        // отдаём контент в вызывающий шаблон
        $view = $controller->run();
        $request->restore();
    }

    if (isset($params['_side'])) {
        $weigth = null;
        if (strpos($params['_side'], ':')) {
            $position = explode(':', $params['_side']);
            $weigth = $position[1];
            $params['_side'] = $position[0];
        }
        $side->set($params['_side'], $module . '_' . $action->getActionName(), $view, $weigth);
    } else {
        return $view;
    }
}

?>
