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

    //$object_id = $mapper->convertArgsToId($request->getParams());
    //$acl = new acl($toolkit->getUser(), )
    /*
    $object_id = $mapper->convertArgsToId($request->getParams());

    $user = $toolkit->getUser();

    $acl = new acl($module, $request->getSection(), $user, $object_id);
    echo $acl->get($action->getActionName()) ? '���� ������' : '��� �������'; */

    $factory = new $modulename($action);
    $controller = $factory->getController();
    $view = $controller->getView();
    $result = $view->toString();

    $request->restore();
if(!is_object($result)) {
    return $result;
}
}

?>
