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
        $id = $this->request->getInteger('id');
        $menuMapper = $this->toolkit->getMapper('menu', 'menu');

        $menu = $menuMapper->searchById($id);

        if ($menu) {
            $tree = $this->request->getArray('menuTree_' . $menu->getId(), SC_POST);
            if ($tree) {
                $nodes = array();
                $this->parseTree($nodes, $tree);

                $menuItemMapper = $this->toolkit->getMapper('menu', 'menuItem');
                foreach ($nodes as $node_id => $node) {
                    $item = $menuItemMapper->searchByIdInMenu($node_id, $menu->getId());
                    if ($item) {
                        if ($node['parent_id'] > 0) {
                            $itemParent = $menuItemMapper->searchById($node['parent_id']);
                            if ($itemParent) {
                                $item->setTreeParent($itemParent);
                            }
                        } else {
                            $item->setTreeParent(0);
                        }

                        $item->setOrder($node['order']);
                        $menuItemMapper->save($item);
                    } else {
                        //@todo: если не найден меню-айтем?
                    }
                }

                return;
            }
        }

        return $this->forward404($menuMapper);

    }

    protected function parseTree(array &$nodes, array $branch, $parent_id = 0) {
        $order = 0;
        foreach ($branch as $node) {
            if (is_array($node) && isset($node['id'])) {
                $order++;
                $id = (int)substr($node['id'], 5);
                if ($id > 0) {
                    $nodes[$id] = array('parent_id' => $parent_id, 'order' => $order);
                    //$nodeId = $node['id'];
                    if (isset($node['childs'])) {
                        $this->parseTree($nodes, $node['childs'], $id);
                    }
                } else {
                    throw new mzzInvalidParameterException('Supplied invalid menu id, excepted int > 0, got: ' . $id . ' (' . $node['id'] . ')');
                }
            }
        }
    }
}
?>