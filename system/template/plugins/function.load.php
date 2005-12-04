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
 * smarty_function_load: ������� ��� ������, ��������� �������
 * 
 * ������� �������������:<br />
 * {load module="some_module_name" action="some_action"}
 * 
 * @param array $params ������� ��������� �������
 * @param object $smarty ������ ������
 * @return string ��������� ������ ������
 * @package system
 * @version 0.1
 */
function smarty_function_load($params, $smarty) {
    $module = $params['module'];
    $modulename = $module . 'Factory';
    $action = $params['action'];
    
    fileLoader::load($module . '.factory');
    $factory = new $modulename($action);
    $controller = $factory->getController();
    $view = $controller->getView();
    $result = $view->toString();
    return $result;
}

?>