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

fileLoader::load('orm/plugins/acl_extPlugin');
fileLoader::load('modules/jip/plugins/jipPlugin');

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

    public function __construct()
    {
        parent::__construct();
        $this->plugins('jip');
        $this->plugins('acl_ext');
    }

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
        foreach ($tree->toArray() as $key => $val) {
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
        $itemMapper = systemToolkit::getInstance()->getMapper('menu', 'menuItem');
        foreach ($menu->getItems() as $item) {
            $itemMapper->delete($item);
        }

        parent::delete($menu);
    }

    public function convertArgsToObj($args)
    {
        if (isset($args['name'])) {
            $menu = $this->searchByName($args['name']);
        } elseif (isset($args['id'])) {
            $menu = $this->searchById($args['id']);
        }

        if (isset($menu) && $menu) {
            return $menu;
        }

        throw new mzzDONotFoundException();
    }

    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'once', 'pk'
            ),
        ),
        'name' => array(
            'accessor' => 'getName',
            'mutator' => 'setName',
         )
    );
}

?>