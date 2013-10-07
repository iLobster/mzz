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

/**
 * smarty_function_form: алиас для вызова form::open
 *
 * @param array $params входные аргументы функции
 * @param object $smarty объект смарти
 * @return string
 * @package system
 * @subpackage template
 */
function smarty_function_form(array $params, Smarty_Internal_Template $template)
{
    return $template->getRegisteredObject('form')->open($params, $template->smarty);
}

?>
