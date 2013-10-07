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
 * Plugin for generating sprite icons
 *
 * @package system
 * @subpackage template
 *
 * params
 *  - sprite (string)
 *      sprite:<set>-<name>[|location]
 *      will return normal icon: <i class="mzz-icon-<set>-<name>"></i> and add's
 *      neccesary css icons.<set>.css from optional module named <location>
 *
 *      if there is no "sprite:" prefix, then it will return simple <img />
 *
 * - jip (boolean)
 *      returns sprite formatted for jipMenu
 *
 * - css (boolean)
 *      simple returns css class. only works with "sprite:" prefix
 *
 * all other params will be passed to resulted html tag
 */
function smarty_function_icon(array $params, Smarty_Internal_Template $template)
{
    static $init = false;

    if (!$init) {
        $template->smarty->loadPlugin('smarty_function_add');
        smarty_function_add(array('file' => 'icons.sys.css'), $template);
        $init = true;
    }

    if (!isset($params['sprite']) || empty($params['sprite'])) {
        return ''; //throw new mzzInvalidParameterException('Empty sprite param');
    }

    $sprite = $params['sprite'];
    $jip = (isset($params['jip']) && $params['jip'] === true) ? true : false;
    $active = isset($params['active']) ? ($params['active'] === true ? true : false) : null;

    if (strpos($sprite, 'sprite:') === 0) {
        $sprite = explode('/', substr($sprite, 7));

        if ($sprite[0] !== 'sys') {
            smarty_function_add(array('file' => (isset($sprite[2]) ? $sprite[2] . '/' : '' ) . 'icons.' . $sprite[0] . '.css'), $template);
            //$this->view->plugin('add', array('file' => (isset($sprite[2]) ? $sprite[2] . '/' : '' ) . 'icons.' . $sprite[0] . '.css'));
        }

        if (count($sprite) >= 2) {
            if ($jip) {
                return "sprite:mzz-icon mzz-icon-" . $sprite[0] . " mzz-icon-" . $sprite[0] . "-" . $sprite[1];
            } else {
                return '<img src="' . SITE_PATH . '/images/spacer.gif" width="16" height="16" class="mzz-icon mzz-icon-' . $sprite[0] . ' mzz-icon-' . $sprite[0] . '-' . $sprite[1] . (($active === true) ? ' active' : (($active === false) ? ' disabled' : '')) . '" alt="" />';
            }
        }
    } else {
        if ($jip) {
            return (strpos($sprite, '://') ? '' : SITE_PATH) . $sprite;
        } else {
            '<img src="' . SITE_PATH . $sprite . '" width="16" height="16" alt="." />';
        }
    }
    return '';

}
?>