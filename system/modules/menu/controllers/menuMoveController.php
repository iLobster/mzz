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
        $name = $this->request->getString('name');
        $menuMapper = $this->toolkit->getMapper('menu', 'menu');

        $menu = $menuMapper->searchByName($name);

        $menuItemMapper = $this->toolkit->getMapper('menu', 'menuItem');

        $data = $this->request->getString('data', SC_POST);
        parse_str($data, $tree);
        if (!$menu || !isset($tree['menuTree_' . $menu->getId()])) {
            return $menuItemMapper->get404()->run();
        }

        $tree = $tree['menuTree_' . $menu->getId()];
        $nodes = array();
        parseTree($nodes, $tree);
        foreach ($nodes as $node_id => $node) {
            $criteria = new criteria;
            $criteria->add('menu_id', $menu->getId())->add('id', $node_id);
            $item = $menuItemMapper->searchOneByCriteria($criteria);
            if ($item) {
                $item->setParent($node['parent_id']);
                $item->setOrder($node['order']);
                $menuItemMapper->save($item);
            }
        }

        return null;
    }
}

function parseTree(&$nodes, $branch, $parent_id = 0) {
    $order = 0;
    foreach ($branch as $node) {
        if (is_array($node) && isset($node['id'])) {
            $order++;
            $nodes[$node['id']] = array('parent_id' => $parent_id, 'order' => $order);
            $nodeId = $node['id'];
            unset($node['id']);
            if (!empty($node)) {
                parseTree($nodes, $node, $nodeId);
            }
        }
    }
}

?>