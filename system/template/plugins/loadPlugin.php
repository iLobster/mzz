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
fileLoader::load('service/blockHelper');

/**
 * Unified load plugin
 *
 * @package system
 * @subpackage template
 * @version 0.1.0
 */
class loadPlugin extends aPlugin
{
    public function run(array $params)
    {

        $params = new arrayDataspace($params);

        $module = $params['module'];
        $block = $params['_block'];
        $actionName = $params['action'];

        $blockHelper = blockHelper::getInstance();
        if ($block && $blockHelper->isHidden($module . '_' . $actionName)) {
            // loading this action of this module has been disabled by blockHelper
            return null;
        }

        $view = loadDispatcher::dispatch($module, $actionName, $params['params']);

        // отдаём контент в вызывающий шаблон, либо сохраняем его в blockHelper
        if ($block) {
            $blockHelper->set($module . '_' . $actionName, $block, $view);
        } else {
            return $view;
        }
    }
}
?>