<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
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
 * smarty_function_meta: функция для Smarty, для установки meta информации (ключевых слов и описания страницы)
 *
 * Примеры использования:<br />
 * <code>
 * {keywords keywords="новости, просмотр, в мире"}
 * {keywords description="просмотр новостей в мире"}
 * {keywords show="keywords"}
 * {keywords show="description" default="информационный сайт"}
 * </code>
 *
 * @param array $params входные аргументы функции
 * @param object $smarty объект смарти
 * @return string
 * @package system
 * @subpackage template
 * @version 0.1
 */
function smarty_function_meta($params, $smarty)
{
    return $smarty->view()->plugin('meta', $params);
}

?>