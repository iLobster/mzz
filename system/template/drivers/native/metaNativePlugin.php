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
 * Native meta plugin
 *
 * @package system
 * @subpackage template
 * @version 0.0.1
 */
class metaNativePlugin extends aNativePlugin
{
    public function run(Array $params = array())
    {
        return $this->view->plugin('meta', $params);
    }
}
?>