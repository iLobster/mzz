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

/**
 * Native load plugin
 * 
 * @package system
 * @subpackage template
 * @version 0.1.0
 */
class loadNativePlugin extends aNativePlugin
{
    public function run($module, $action, array $params = array(), $block = null)
    {
        $params = array('module' => $module, 'action' => $action, 'params' => $params);

        if (!empty($block)) {
            $params['_block'] = $block;
        }

        return $this->view->plugin('load', $params);
    }
}
?>