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
 * @subpackage request
 * @version $Id$
*/

/**
 * Модификатор ucfirst для smarty
 *
 * Type:     modifier<br>
 * Name:     ucfirst<br>
 * @author   mzz
 * @param string исходная строка
 * @param bool приводить ли строку к нижнму регистру
 * @return string
 */
function smarty_modifier_ucfirst($string, $withToLower = false)
{
    if ($withToLower) {
        $string = mzz_strtolower($string);
    }

    return mzz_ucfirst($string);
}
?>