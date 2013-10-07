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
 * smarty_modifier_i18n: модификатор для вызова i18n

 * @param string $params строка для перевода
 * @param string $module имя модуля
 * @return string переведённая строка
 * @package system
 * @subpackage template
 */
function smarty_modifier_i18n($name, $module = 'simple')
{
    return i18n::getMessage($name, $module);
}

?>