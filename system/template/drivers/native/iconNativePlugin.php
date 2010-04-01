<?php
/**
 * $URL: $
 *
 * MZZ Content Management System (c) 2010
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage template
 * @version $Id: $
*/

/**
 * Native templates icon plugin for sprites,
 * automaticaly loads css for selected set (/css/icons.<set-name>.css)
 *
 * Usage:
 * <code>
 * sprite - image path (will be prepended with SITE_PATH)
 *          sprite in formate sprite:<set-name>/<icon-name>[/<module-name>]
 * [jip - false|true] - for use with jipMenu
 * [active - null|true|false] -  auto, active or disabled state
 *
 * {icon sprite="/images/add.gif"} = <img src="/images/add.gif" width="16" height="16" alt="." />
 * {icon sprite="sprite:set/name"} = <img src="/images/spacer.gif" class="mzz-icon mzz-icon-set mzz-icon-set-name" width="16" height="16" alt="." />
 * {icon sprite="sprite:set/name" jip=true} = sprite:mzz-icon mzz-icon-set mzz-icon-set-name
 * </code>
 *
 * @package system
 * @subpackage template
 * @version 0.1.0
 */
class iconNativePlugin extends aNativePlugin
{
    public function run($sprite, $jip = false, $active = null)
    {
        if (strpos($sprite, 'sprite:') === 0) {
            $sprite = explode('/', substr($sprite, 7));
            $this->native->add((isset($sprite[2]) ? $sprite[2] . '/' : '' ) . 'icons.' . $sprite[0] . '.css');

            if (count($sprite) >= 2) {
                if ($jip) {
                    return "sprite:mzz-icon mzz-icon-" . $sprite[0] . " mzz-icon-" . $sprite[0] . "-" . $sprite[1];
                } else {
                    return '<img src="' . SITE_PATH . '/images/spacer.gif" width="16" height="16" class="mzz-icon mzz-icon-' . $sprite[0] . ' mzz-icon-' . $sprite[0] . '-' . $sprite[1] . (($active === true) ? ' active' : (($active === false) ? ' disabled' : '')) . '" alt="" />';
                }
            }
        } else {
            if ($jip) {
                return "'" . SITE_PATH . $sprite . "'";
            } else {
                '<img src="' . SITE_PATH . $sprite . '" width="16" height="16" alt="." />';
            }
        }
        return '';
    }
}
?>
