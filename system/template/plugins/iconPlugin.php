<?php
/**
 * $URL$
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
 * @version $Id$
 */

fileLoader::load('template/plugins/aPlugin');

/**
 * Plugin for generating sprite icons
 *
 * @package system
 * @subpackage template
 * @version 0.1.0
 */
class iconPlugin extends aPlugin
{
    public function run(array $params)
    {
        if (!isset($params['sprite']) || empty($params['sprite'])) {
            return ''; //throw new mzzInvalidParameterException('Empty sprite param');
        }

        $sprite = $params['sprite'];
        $jip = (isset($params['jip']) && $params['jip'] === true) ? true : false;
        $active = isset($params['active']) ? ($params['active'] === true ? true : false) : null;

        if (strpos($sprite, 'sprite:') === 0) {
            $sprite = explode('/', substr($sprite, 7));
            $this->view->plugin('add', array('file' => (isset($sprite[2]) ? $sprite[2] . '/' : '' ) . 'icons.' . $sprite[0] . '.css'));

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