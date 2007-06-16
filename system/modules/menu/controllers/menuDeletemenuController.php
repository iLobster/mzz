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
 * menuDeletemenuController: контроллер для метода delete модуля menu
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menuDeletemenuController extends simpleController
{
    public function getView()
    {
        $menuMapper = $this->toolkit->getMapper('menu', 'menu');
        $itemMapper = $this->toolkit->getMapper('menu', 'item');
        $id = $this->request->get('id', 'integer', SC_PATH);

        $menu = $menuMapper->searchById($id);

        foreach ($menu->searchItems() as $item) {
            $itemMapper->delete($item->getId());
        }

        $menuMapper->delete($menu->getId());

        return jipTools::redirect();
    }
}

?>