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
 * Native title plugin
 *
 * @package system
 * @subpackage template
 * @version 0.0.1
 */
class titleNativePlugin extends aNativePlugin
{
    public function run($params = array())
    {
        $_params = array();
        if (is_string($params)) {
            $_params['append'] = $params;
        } else if (is_array($params)) {
            $_params = $params;
        }

        return $this->view->plugin('title', $_params);
    }
}
?>