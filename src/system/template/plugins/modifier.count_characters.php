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


/**
 * Smarty count_characters modifier plugin
 *
 * Type:     modifier<br>
 * Name:     count_characteres<br>
 * Purpose:  count the number of characters in a text
 * @link http://smarty.php.net/manual/en/language.modifier.count.characters.php
 *          count_characters (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param boolean include whitespace in the character count
 * @return integer
 */
function smarty_modifier_count_characters($string, $include_spaces = false)
{
    if ($include_spaces)
       return(mzz_strlen($string));

    return preg_match_all("/[^\s]/",$string, $match);
}