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

fileLoader::load('menu');

/**
 * menuMapper: маппер
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menuMapper extends mapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'menu';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'menu';

    protected $table = 'menu_menu';


    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    public function searchByName($name)
    {
        return $this->searchOneByField('name', $name);
    }

    public function searchItemsById($menuId)
    {
        $criteria = new criteria;
        $criteria->add('menu_id', $menuId)->setOrderByFieldAsc('order')->setOrderByFieldDesc('id');

        $itemMapper = systemToolkit::getInstance()->getMapper('menu', 'menuItem');
        $data = $itemMapper->searchAllByCriteria($criteria);
        $tree = $this->buildTree($data);
        return $tree;
    }

    private function buildTree($tree, $id = 0)
    {
        $result = array();
        foreach ($tree as $key => $val) {
            if ($id == $val->getParent()) {
                unset($tree[$key]);
                $result[$key] = $val;
                $result[$key]->setChildrens($this->buildTree($tree, $key), $val);
            }
        }
        return $result;
    }

    public function get404()
    {
        fileLoader::load('menu/controllers/menu404Controller');
        return new menu404Controller();
    }

    public function delete(menu $menu)
    {
        $itemMapper = systemToolkit::getInstance()->getMapper('menu', 'menuItem', $this->section);
        foreach ($menu->getItems() as $item) {
            $itemMapper->delete($item);
        }

        parent::delete($menu);
    }

    public function convertArgsToObj($args)
    {
        if (isset($args['name'])) {
            $menu = $this->searchByName($args['name']);

            if ($menu) {
                return $menu;
            }
        }

        throw new mzzDONotFoundException();
    }

    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'once', 'pk'
            )
        ),
    );
}

?>