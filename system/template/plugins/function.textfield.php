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

/**
 * smarty_function_textfield: функция для смарти
 *
 * @param array $params входные аргументы функции
 * @param object $smarty объект смарти
 * @return string результат работы модуля
 * @package system
 * @subpackage template
 * @version 0.1
 */
function smarty_function_textfield($params, $smarty)
{
    fileLoader::load('forms/formElement');
    fileLoader::load('forms/formTextField');
    $name = $params['name'];
    $value = isset($params['value']) ? $params['value'] : '';
    unset($params['name']);
    unset($params['value']);
    return formTextField::toString($name, $value, $params);
}

?>