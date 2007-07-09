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

        $name = $this->request->get('name', 'string');
        $menu = $menuMapper->searchByName($name);

        if (!$menu) {
            //todo 404
            throw new mzzDONotFoundException();
        }

        $items = $menu->searchItems();

        $this->smarty->assign('items', $items);
        return $this->smarty->fetch('menu/view.tpl');
    }
}

?>