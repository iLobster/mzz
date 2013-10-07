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

/**
 * smarty_modifier_filesize: конвертируем байты в необходимые единицы измерения:
 * байты, килобайты, мегабайты, гигабайты, терабайты, петабайты
 *
 * Примеры использования:<br />
 * <code>
 * {$size|filesize}
 * </code>
 *
 * @param integer $bytes размер в байтах
 * @return string
 * @package system
 * @subpackage template
 */
function smarty_modifier_filesize($bytes)
{
   // die($bytes);
    $bytes = max(0, (int) $bytes);
    $units = array('б', 'Кб', 'Мб', 'Гб', 'Тб', 'Пб');
    $power = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
    return round($bytes / pow(1024, $power),2) . ' ' .$units[$power];
}
?>