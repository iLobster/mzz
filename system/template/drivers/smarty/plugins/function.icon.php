<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2009
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
 * smarty_function_icon: функция для смарти, генератор спрайтовых иконок,
 * автоматически будет подгружен css для указанного сета (/css/icons.<set-name>.css)
 *
 * Примеры использования:
 * <code>
 * sprite - ссылка на файл (вначало будет добавлен путь SITE_PATH)
 *          или спрайт в формате sprite:<set-name>/<icon-name>[/<module-name>]
 * [jip - false|true] - сгенерить строку для jipMenu
 * [active - false|true|null] - активное состояние иконки или авто, если не задано
 *
 * {icon sprite="/images/add.gif"} = <img src="/images/add.gif" width="16" height="16" alt="." />
 * {icon sprite="sprite:set/name"} = <img src="/images/spacer.gif" class="mzz-icon mzz-icon-set mzz-icon-set-name" width="16" height="16" alt="." />
 * {icon sprite="sprite:set/name" jip=true} = sprite:mzz-icon mzz-icon-set mzz-icon-set-name
 * </code>
 *
 * @param array $params входные аргументы функции
 * @param object $smarty объект смарти
 * @return string|null
 * @package system
 * @subpackage template
 * @version 0.1.0
 */


function smarty_function_icon($params, $smarty)
{
    return $smarty->view()->plugin('icon', $params);
}
?>