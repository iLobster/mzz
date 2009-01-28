<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * menuViewController: контроллер для метода view модуля menu
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menuViewController extends simpleController
{
    protected function getView()
    {
        $menuMapper = $this->toolkit->getMapper('menu', 'menu');

        $prefix = $this->request->getString('tplPrefix');
        if (!empty($prefix)) {
            $prefix .= '/';
        }

        $name = $this->request->getString('name');
        $menu = $menuMapper->searchByName($name);
        if (empty($menu)) {
            return $menuMapper->get404()->run();
        }

        //перенесли это в menuItemMapper::create();
        /*
        foreach ($menu->getItems() as $item) {
            $item->setUrlLang($this->getCurrentLang(), $this->request->getString('lang'));
        }
        */

        $this->smarty->assign('menu', $menu);
        $this->smarty->assign('prefix', $prefix);
        return $this->smarty->fetch('menu/' . $prefix . 'view.tpl');
    }

    /*
    protected function getCurrentLang()
    {
        if (!systemConfig::$i18nEnable) {
            return null;
        }

        $lang = $this->request->getString('lang');
        if (empty($lang)) {
            $lang = $this->toolkit->getLocale()->getName();
        }
        return $lang;
    }
    */
}

?>