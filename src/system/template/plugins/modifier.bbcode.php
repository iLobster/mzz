<?php
/**
 * MZZ Content Management System (c)
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 */

fileLoader::load('service/bbcode');

/**
 * smarty_modifier_bbcode: смарти плагин для преобразования bbcode
 *
 * Примеры использования:<br />
 * <code>
 * {$text|bbcode}
 * </code>
 *
 * @param string $string исходная строка
 * @return string
 * @package system
 * @subpackage template
 */
function smarty_modifier_bbcode($string)
{
    $bbcode_parser = new bbcode($string);
    return $bbcode_parser->parse();
}
?>