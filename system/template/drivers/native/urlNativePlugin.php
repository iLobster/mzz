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
 * Native url plugin
 *
 * @package system
 * @subpackage template
 * @version 0.1.0
 */
class urlNativePlugin extends aNativePlugin
{
    public function run($route = null, array $params = array(), $appendGet = false)
    {
        $_params = array();

        if ($route === true) {
            $_params['onlyPath'] = true;
        } elseif(!empty($route)) {
            $_params['route'] = $route;
        }

        $_params['appendGet'] = $appendGet;

        $_params = array_merge($params, $_params);

        return $this->view->plugin('url', $_params);
    }
}
?>