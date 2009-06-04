<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

fileLoader::load('libs/smarty/plugins/modifier.escape');

/**
 * Smarty escape modifier plugin
 *
 * Type:     modifier<br>
 * Name:     h<br>
 * Purpose:  Escape the string according to escapement type
 * @link http://smarty.php.net/manual/en/language.modifier.escape.php
 *          escape (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param html|htmlall|url|quotes|hex|hexentity|javascript
 * @return string
 */
function smarty_modifier_h($string, $esc_type = 'html', $char_set = 'UTF-8')
{
    return smarty_modifier_escape($string, $esc_type, $char_set);
}

/* vim: set expandtab: */

?>
