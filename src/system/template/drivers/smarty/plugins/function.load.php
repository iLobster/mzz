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
 * @version 0.4.8
 */
function smarty_function_load($params, $smarty)
{
    $allParams = $params;
    $allParams['params'] = $params;
    foreach (array('module', 'action', '_block') as $name) {
        unset($allParams['params'][$name]);
    }

    return $smarty->view()->plugin('load', $allParams);
}

?>