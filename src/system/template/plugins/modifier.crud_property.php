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
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
function smarty_modifier_crud_property($name, $property)
{
    $modifier = '';
    if (isset($property['type']) && $property['type'] == 'char') {
        $modifier = 'h';
    }

    return '{$' . $name . '->' . $property['accessor'] . '()' . ($modifier ? '|' . $modifier : '') . '}';
}

?>