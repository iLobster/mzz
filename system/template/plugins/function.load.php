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

fileLoader::load('core/loadDispatcher');
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
 * @version 0.4.8
 */
function smarty_function_load($params, $smarty)
{
    $allParams = $params;
    $allParams['params'] = $params;
    foreach (array('module', 'section', 'action', '_side') as $name) {
        unset($allParams['params'][$name]);
    }
    $allParams = new arrayDataspace($allParams);

    $section = $allParams['section'];
    $module = $allParams['module'];
    $side = $allParams['_side'];
    $actionName = $allParams['action'];

    $sideHelper = sideHelper::getInstance();
    if ($side && $sideHelper->isHidden($module . '_' . $actionName)) {
        // loading this action of this module has been disabled by sideHelper
        return null;
    }

    $view = loadDispatcher::dispatch($section, $module, $actionName, $allParams['params']);

    // отдаём контент в вызывающий шаблон, либо сохраняем его в sideHelper
    if ($side) {
        $sideHelper->set($side, $module . '_' . $actionName, $view);
    } else {
        return $view;
    }
}

?>
