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
 * smarty_function_add: функция для смарти, загрузчик элементов сайта (например JS, CSS)
 *
 * Примеры использования:<br />
 * <code>
 * {add file="styles.css"}
 * {add file="css:style_generator.php?print=1" tpl="css_print.tpl"}
 * </code>
 *
 * @param array $params входные аргументы функции
 * @param object $smarty объект смарти
 * @return null|void null если файл дубликат
 * @package system
 * @subpackage template
 * @version 0.2.3
 */
function smarty_function_add($params, $smarty)
{

    if (!isset($params['file']) || empty($params['file'])) {
        //var_dump($params);
        throw new mzzInvalidParameterException('Пустой атрибут file');
    }

    $files = array($params['file']);
    $join = (isset($params['join']) && $params['join'] == false) ? false : true;
    $tpl = (isset($params['tpl']) && !empty($params['tpl'])) ? $params['tpl'] : null;

    if (isset($params['require'])) {
        $files = array_merge(explode(',', $params['require']), $files);
    }
    
    $smarty->addMedia($files, $join, $tpl);
}

?>