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
 * menuDeletemenuController: ���������� ��� ������ delete ������ menu
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menuDeletemenuController extends simpleController
{
    protected function getView()
    {
        $menuMapper = $this->toolkit->getMapper('menu', 'menu');
        $itemMapper = $this->toolkit->getMapper('menu', 'menuItem');
        $name = $this->request->get('name', 'string');

        $menu = $menuMapper->searchByName($name);

        foreach ($menu->getItems() as $item) {
            $itemMapper->delete($item);
        }

        $menuMapper->delete($menu->getId());

        return jipTools::redirect();
    }
}

?>