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
 * menuViewController: ���������� ��� ������ view ������ menu
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menuViewController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer');
        $menuMapper = $this->toolkit->getMapper('menu', 'menu');
        $menu = $menuMapper->searchById($id);

        $items = $menu->searchAllItems();
        $this->smarty->assign('items', $items);
        return $this->smarty->fetch('menu/view.tpl');
    }
}

?>