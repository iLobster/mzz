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
 * menuDeleteController: ���������� ��� ������ delete ������ menu
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menuDeleteController extends simpleController
{
    public function getView()
    {
        $itemMapper = $this->toolkit->getMapper('menu', 'menuItem');
        $id = $this->request->get('id', 'integer', SC_PATH);

        $item = $itemMapper->searchById($id);

        if ($item) {
            $this->deleteBranch($item);
            $itemMapper->delete($item);
        }

        return jipTools::redirect();
    }

    private function deleteBranch(menuItem $item)
    {
        $itemMapper = $this->toolkit->getMapper('menu', 'menuItem');
        foreach ($item->getChildrens() as $child) {
            $this->deleteBranch($child);
            $itemMapper->delete($child);
        }
    }
}

?>