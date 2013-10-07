<?php
/**
 * MZZ Content Management System (c)
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 */

fileLoader::load('core/loadDispatcher');
fileLoader::load('service/blockHelper');

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
 */
function smarty_function_load(array $params, Smarty_Internal_Template $template)
{
    $allParams = $params;
    $allParams['params'] = $params;
    foreach (array('module', 'action', '_block') as $name) {
        unset($allParams['params'][$name]);
    }

    $params = new arrayDataspace($params);

    $module = $params['module'];
    $action = $params['action'];
    $block = $params['_block'];
    $blockName = $params['_blockName'];

    $blockHelper = blockHelper::getInstance();
    if ($block && $blockHelper->isHidden($blockName)) {
        // loading this action of this module has been disabled by blockHelper
        return null;
    }

    $view = loadDispatcher::dispatch($module, $action, $allParams['params']);

    // отдаём контент в вызывающий шаблон, либо сохраняем его в blockHelper
    if ($block) {
        $blockHelper->set($blockName, $block, $view);
    } else {
        return $view;
    }
}

?>