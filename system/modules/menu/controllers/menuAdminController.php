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
 * menuAdminController: контроллер для метода admin модуля menu
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menuAdminController extends simpleController
{
    protected function getView()
    {
        $menuId = $this->request->getInteger('menuId', SC_POST);
        if ($menuId > 0) {
            $this->smarty->disableMain();
            $data = $this->request->getString('data', SC_POST);
            parse_str($data, $tree);

            $nodes = array();

            if (isset($tree['menuTree_' . $menuId])) {
                $tree = $tree['menuTree_' . $menuId];

                function parseTree(&$nodes, $branch, $parent_id) {
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

                parseTree($nodes, $tree, 0);

                $menuItemMapper = $this->toolkit->getMapper('menu', 'menuItem');
                foreach ($nodes as $node_id => $node) {
                    $criteria = new criteria;
                    $criteria->add('menu_id', $menuId)->add('id', $node_id);
                    $item = $menuItemMapper->searchOneByCriteria($criteria);
                    if ($item) {
                        $item->setParent($node['parent_id']);
                        $item->setOrder($node['order']);
                        $menuItemMapper->save($item);
                    }
                }

                return '<pre>' . print_r($tree, true) . '</pre>';
            }

            return null;
        }

        $menuMapper = $this->toolkit->getMapper('menu', 'menu');
        $menuFolderMapper = $this->toolkit->getMapper('menu', 'menuFolder');
        $folder = $menuFolderMapper->getFolder();
        $menus = $menuMapper->searchAll();

        $this->smarty->assign('menus', $menus);
        $this->smarty->assign('folder', $folder);
        return $this->smarty->fetch('menu/admin.tpl');
    }
}

?>