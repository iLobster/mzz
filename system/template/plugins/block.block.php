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
fileLoader::load('service/sideHelper');

/**
 * smarty_block_sideBlock: записывает содержимое между тегами в переменную с именем, указанным аргументом name
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
function smarty_block_block($params, $content, $smarty)
{
    if (empty($params['align']) || empty($params['name'])) {
        throw new mzzRuntimeException('Align or name for side block is not defined');
    }
    $side = sideHelper::getInstance();
    $weigth = null;
    if (strpos($params['align'], ':')) {
        $position = explode(':', $params['align']);
        $weigth = $position[1];
        $params['align'] = $position[0];
    }
    $side->set($params['align'], $params['name'], $content, $weigth);
}


?>
