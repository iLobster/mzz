<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Get seconds and microseconds
 * @return double
 */
function smarty_core_get_microtime($params, &$smarty)
{
    return microtime(1);
}

/* vim: set expandtab: */

?>
