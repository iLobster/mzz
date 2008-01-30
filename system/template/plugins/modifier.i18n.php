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
 * smarty_modifier_i18n: модификатор для вызова i18n

 * @param string $params строка для перевода
 * @return string переведённая строка
 * @package system
 * @subpackage template
 * @version 0.1
 */
function smarty_modifier_i18n($name, $module = 'simple')
{
    return i18n::getMessage($name, $module);
}

?>