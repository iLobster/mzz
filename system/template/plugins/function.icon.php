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
 * smarty_function_icon: функция для смарти, генератор спрайтовых иконок
 *
 * Примеры использования:
 * <code>
 * sprite - ссылка на файл (вначало будет добавлено SITE_PATH)
 *          или спрайт в формате sprite:name/index[/overlay]
 * [jip - false|true] - сгенерить строку для jipMenu
 * [active - false|true] - активное состояние иконки (имеет приоритет)
 * [disabled - false|true] - задизабленное состояние
 *
 * {icon sprite="/templates/images/add.gif"} = <img src="/templates/images/add.gif" width="16" height="16" alt="icon" />
 * {icon sprite="sprite:mzz-icon/mzz-icon-folder/mzz-overlay-add"} = <span class="mzz-icon mzz-icon-folder"><span class="mzz-overlay mzz-overlay-add"></span></span>
 * {icon sprite="sprite:mzz-icon/mzz-icon-folder/mzz-overlay-add" jip=true} = {'sprite':'mzz-icon','index':'mzz-icon-folder', 'overlay':'mzz-overlay-add'}
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
    if (isset($params['sprite'])) {

        $jip = (isset($params['jip']) && $params['jip'] === true) ? true : false;
        $active = (isset($params['active']) && $params['active'] === true) ? true : false;
        $disabled = (!$active && (isset($params['disabled']) && $params['disabled'] === true)) ? true : false;

        if (strpos($params['sprite'], 'sprite:') === 0) {
            $sprite = explode('/', substr($params['sprite'], 7));
            if (count($sprite) >= 2) {
                if ($jip) {
                    return "{'sprite':'" . $sprite[0] . "', 'index':'" . $sprite[1] . "'" . (isset($sprite[2]) ? ", 'overlay':'" . $sprite[2] . "'" : "") ."}";
                } else {
                    return '<span class="' . $sprite[0] . ' ' . $sprite[1] . (($active) ? ' active' : (($disabled) ? ' disabled' : '')) . '">'
                           . (isset($sprite[2]) ? '<span class="mzz-overlay ' . $sprite[2] . '"></span>' : '' ) . '</span>';
                }
            }
        } else {
            if ($jip) {
                return "'" . SITE_ROOT . $params['sprite'] . "'";
            } else {
                return '<img src="' . SITE_ROOT . $params['sprite'] . '" width="16" height="16" alt="." />';
            }
        }
    }

}
?>