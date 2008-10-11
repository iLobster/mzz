<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/template/plugins/function.url.php $
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
 * @version $Id: function.url.php 2402 2008-02-24 01:30:34Z mz $
*/

/**
 * smarty_function_form: алиас для вызова form::open
 *
 * @param array $params входные аргументы функции
 * @param object $smarty объект смарти
 * @return string
 * @package system
 * @subpackage template
 * @version 0.1
 */
function smarty_function_form($params, $smarty)
{
    return $smarty->get_registered_object('form')->open($params, $smarty);
}

?>
