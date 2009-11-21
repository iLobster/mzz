<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/template/plugins/block.block.php $
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
 * @version $Id: block.block.php 3991 2009-11-21 19:19:27Z mz $
*/
fileLoader::load('service/blockHelper');

/**
 * smarty_block_fblock: записывает содержимое между тегами в переменную с именем, указанным аргументом name
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
function smarty_block_fblock($params, $content, $smarty)
{
    if (empty($params['position']) || empty($params['name'])) {
        throw new mzzRuntimeException('Block position for block helper is not defined');
    }
    if (empty($params['name'])) {
        throw new mzzRuntimeException('Block name for block helper is not defined');
    }
    $side = blockHelper::getInstance();
    $weigth = null;
    if (strpos($params['position'], ':')) {
        $position = explode(':', $params['position']);
        $weigth = $position[1];
        $params['position'] = $position[0];
    }
    $side->set($params['name'], $params['position'], $content, $weigth);
}


?>
