<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * smarty_modifier_word_ending: модификатор выбора для числа слова с правильным окончания
 *
 * Примеры использования:<br />
 * <code>
 * {$comments|@sizeof|word_ending:"комментариев,комментарий,комментария"}
 * </code>
 * В последнем аргументе первое слово идет для числа 10, 11 и т.п, вторым для 1 и т.п., третьем для 2 и т.п.
 *
 * @param integer $num число
 * @param string $words три слова через запятую: для числа 5, для 1, для 2
 * @return string число и слово с правильным окончанием через пробел
 * @package system
 * @subpackage template
 * @version 0.1
 */
function smarty_modifier_word_ending($num, $words)
{
    $words = explode(",", $words);
    $real_num = $num;
    $num = abs($num);
    $index = $num % 100;
    if ($index >=11 && $index <= 14) {
        $index = 0;
    } else {
        $index = (($index %= 10) < 5 ? ($index > 2 ? 2 : $index): 0);
    }
    
    return $real_num . ' ' . trim($words[$index]);
}
?>