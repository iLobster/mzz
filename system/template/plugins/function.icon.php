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
 *          или спрайт в формате sprite:<set-name>/<icon-name>
 * [jip - false|true] - сгенерить строку для jipMenu
 * [active - false|true] - активное состояние иконки (имеет приоритет)
 * [disabled - false|true] - задизабленное состояние
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
    $smarty->loadPlugin('smarty_function_add');
    if (isset($params['sprite'])) {
        
        $jip = (isset($params['jip']) && $params['jip'] === true) ? true : false;
        $active = (isset($params['active']) && $params['active'] === true) ? true : false;
        $disabled = (!$active && (isset($params['disabled']) && $params['disabled'] === true)) ? true : false;

        if (strpos($params['sprite'], 'sprite:') === 0) {
            $sprite = explode('/', substr($params['sprite'], 7));
            smarty_function_add(array('file' => 'icons.' . $sprite[0] . '.css'), $smarty);
            if (count($sprite) >= 2) {
                if ($jip) {
                    return "sprite:mzz-icon mzz-icon-" . $sprite[0] . " mzz-icon-" . $sprite[0] . "-" . $sprite[1];
                } else {
                    return '<img src="' . SITE_PATH . '/images/spacer.gif" width="16" height="16" class="mzz-icon mzz-icon-' . $sprite[0] . ' mzz-icon-' . $sprite[0] . '-' . $sprite[1] . (($active) ? ' active' : (($disabled) ? ' disabled' : '')) . '" />';
                }
            }
        } else {
            if ($jip) {
                return "'" . SITE_PATH . $params['sprite'] . "'";
            } else {
                return '<img src="' . SITE_PATH . $params['sprite'] . '" width="16" height="16" alt="." />';
            }
        }
    }

}
?>