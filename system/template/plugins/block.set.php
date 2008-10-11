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
 * smarty_block_set: записывает содержимое между тегами в переменную с именем, указанным аргументом name
 *
 * Примеры использования:<br />
 * <code>
 * {set name="url"}{url}{/set} {$url}
 * </code>
 *
 * @param array $params входные аргументы функции
 * @param string $content содержимое блока
 * @param object $smarty объект смарти
 * @package system
 * @subpackage template
 * @version 0.1
 */
function smarty_block_set($params, $content, $smarty)
{
    if (is_null($content) || empty($params['name'])) {
        return;
    }

    $smarty->assign($params['name'], $content);

}


?>
