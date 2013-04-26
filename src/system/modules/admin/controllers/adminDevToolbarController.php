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

        $mods = $adminMapper->getModules();

        $hiddenClasses = array_flip(explode(',', $this->request->getString('mzz-devToolbarH', SC_COOKIE)));

        $this->view->assign('hiddenClasses', $hiddenClasses);

        $modules = array('app' => array(), 'sys' => array());
        
        foreach ($mods as $module) {
           if ($module->isSystem()) {
               $modules['sys'][$module->getName()] = $module;
           } else {
                $modules['app'][$module->getName()] = $module;
           }
        }

        ksort($modules['sys']);
        ksort($modules['app']);

         $this->view->assign('modules',  $modules);
        return $this->render('admin/devToolbar.tpl');
    }
}

?>