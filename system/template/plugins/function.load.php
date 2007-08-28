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
 * smarty_function_load: ������� ��� ������, ��������� �������
 *
 * ������� �������������:<br />
 * <code>
 * {load module="some_module_name" action="some_action"}
 * </code>
 *
 * @param array $params ������� ��������� �������
 * @param object $smarty ������ ������
 * @return string ��������� ������ ������
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

    // �������� ����������� ��� ������� ������ � �������������� ������
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

    $request->setAction($action->getActionName());

    if(!empty($params['section'])) {
        $request->setSection($params['section']);
        unset($params['section']);
    }

    foreach ($params as $name => $value) {
        $request->setParam($name, $value);
    }

    $access = true;

    // ��������� - �� ��������� �� � ������ ������� ������ �������� ����
    if (!isset($params['403handle']) || $params['403handle'] != 'none') {

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

            //var_dump($actionName); var_dump($object_id);

            //$access = $acl->get($actionName);
            $access = $obj->getAcl($actionName);

        } catch (mzzDONotFoundException $e) {
            $controller = $mapper->get404();
        }
    }

    // ���������, ������� �� ������ ����� �������� ����
    if (isset($params['403handle']) && $params['403handle'] == 'manual') {
        $request->setParam('access', $access);
        $access = true;
    }

    if ($access) {
        // ���� ����� �� ������ ������ ���� - ���������
        $factory = new $modulename($action);
    } else {
        // ���� ���� ��� - ��������� ���� ����������� ��������� � 403 ������, ���� ����������������
        if (!isset($params['403tpl'])) {
            fileLoader::load('simple/simple403Controller');
            $controller = new simple403Controller();
        } else {
            $smarty = $toolkit->getSmarty();
            $view = $smarty->fetch($params['403tpl']);
            $request->restore();
            return $view;
        }
    }

    if (!isset($controller)) {
        $controller = $factory->getController();
    }

    // ����� ������� � ���������� ������
    $view = $controller->run();
    $request->restore();
    return $view;
}

?>