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
 * menuChangeOrderController: контроллер для метода moveUp модуля menu
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menuChangeOrderController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer');
        $menuItemMapper = $this->toolkit->getMapper('menu', 'menuItem');

        $item = $menuItemMapper->searchById($id);

        if (!$item) {
            $menuMapper = $this->toolkit->getMapper('menu', 'menu');
            return $menuMapper->get404()->run();
        }

        $direction = ($this->request->getAction() == 'moveUp') ? 'up' : 'down';
        $item->changeOrder($direction);

        return jipTools::redirect();
    }
}

?>