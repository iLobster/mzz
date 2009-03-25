<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * adminDevToolbarController: контроллер для метода devToolbar модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.1
 */
class adminDevToolbarController extends simpleController
{
    protected function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');

        $info = $adminMapper->getInfo();
//echo '<pre>'; var_dump($info); echo '</pre>';
/*        $access = array();

        foreach ($info['data'] as $module) {
            foreach ($module as $class) {
                $name = $class['class'];
                $access[$name] = $class;
                $access[$name]['admin'] = $info['admin'][$name];
            }
        }*/

        //$this->smarty->assign('access', $access);
        $this->smarty->assign('modules', $info);
        $this->smarty->assign('latestObjects', $adminMapper->getLatestRegisteredObj());
        return $this->smarty->fetch('admin/devToolbar.tpl');
    }
}

?>