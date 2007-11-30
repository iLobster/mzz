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
 * menuMoveController: контроллер для метода move модуля menu
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menuMoveController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer');
        $target = $this->request->get('target', 'string');

        $menuItemMapper = $this->toolkit->getMapper('menu', 'menuItem');

        $item = $menuItemMapper->searchById($id);

        if (!$item) {
            $menuMapper = $this->toolkit->getMapper('menu', 'menu');
            return $menuMapper->get404()->run();
        }

        $item->move($target);
        return jipTools::redirect();
    }
}

?>