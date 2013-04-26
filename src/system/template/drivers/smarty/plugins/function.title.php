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
 * smarty_function_title: функция для Smarty, сборка заголовка страницы
 *
 * Примеры использования:<br />
 * <code>
 * {title append="Новости" separator=" - "}
 * {title append="2007"}
 * {title append="Список"}
 * {title separator=" | "} // Новости - 2007 | Список
 * {title separator=" | " end=" - "}
 * {title separator=" | " start=" - "}
 * </code>
 *
 * Значения аргументов end или start присоединяются к результату только
 * при выводе заголовка и если он не пустой (одно из применений: разделитель
 * для названия сайта и цепочки заголовков)
 *
 * @param array $params входные аргументы функции
 * @param object $smarty объект смарти
 * @return string|void заголовок если не указан параметр append
 * @package system
 * @subpackage template
 * @version 0.1.1
 */
function smarty_function_title($params, $smarty)
{
    return $smarty->view()->plugin('title', $params);
}

?>