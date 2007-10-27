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

fileLoader::load('menu/menuItem');

/**
 * itemMapper: маппер
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menuItemMapper extends simpleCatalogueMapper
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
    protected $className = 'menuItem';

    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    public function getMenuChildrens($parent_id, $menu_id)
    {
        $criteria = new criteria;
        $criteria->add('parent_id', (int)$parent_id)->add('menu_id', (int)$menuId)->setOrderByFieldDesc('order')->setOrderByFieldDesc('id');

        $data = $this->searchAllByCriteria($criteria);
        return $data;
    }

    public function getMaxOrder($parent_id, $menu_id)
    {
        $db = DB::factory();
        $criteria = new criteria($this->table);
        $criteria->addSelectField(new sqlFunction('MAX', 'order', true), 'maxorder')->add('parent_id', (int)$parent_id)->add('menu_id', (int)$menu_id);
        $select = new simpleSelect($criteria);
        $stmt = $db->query($select->toString());
        $maxorder = $stmt->fetch();
        return (int)$maxorder['maxorder'];
    }

    public function searchByOrderAndParentInMenu($order, $parent, $menu_id)
    {
        $criteria = new criteria;
        $criteria->add('order', (int)$order)->add('parent_id', (int)$parent)->add('menu_id', (int)$menu_id);
        return $this->searchOneByCriteria($criteria);
    }


    public function move(menuItem $item, $target)
    {
        if ($target == 'up' || $target == 'down') {
            $item = $this->changeOrder($item, $target);
        } elseif ($item->getParent() != $target) {
            $item = $this->changeParent($item, $target);
        }

        $this->save($item);
    }

    protected function changeOrder(menuItem $item, $target)
    {
        $order = ($target == 'up') ? $item->getOrder() - 1 : $item->getOrder() + 1;
        $next = $this->searchByOrderAndParentInMenu($order, $item->getParent(), $item->getMenu()->getId());
        if ($next) {
            $item->setOrder($next->getOrder());
            $next->setOrder($item->getOrder());
            $this->save($next);
        }
        return $item;
    }

    protected function changeParent(menuItem $item, $target)
    {
        $new = $this->searchById($target);

        if ($new || $target == 0) {
            $this->shift($item->getParent(), $item->getOrder());

            $item->setOrder($this->getMaxOrder($target, $item->getMenu()->getId()) + 1);
            $item->setParent($target);
        }

        return $item;
    }

    public function delete(menuItem $item)
    {
        $childrens = $this->getMenuChildrens($item->getId(), $item->getMenu());
        foreach ($childrens as $child) {
            parent::delete($child->getId());
        }

        $this->shift($item->getParent(), $item->getOrder());
        parent::delete($item->getId());
    }

    protected function shift($parent_id, $order)
    {
        $stmt = $this->db->prepare('UPDATE ' . $this->table . ' SET `order` = `order` - 1 WHERE `parent_id` = :parent_id AND `order` > :order');
        $stmt->bindParam('parent_id', $parent_id, PDO::PARAM_INT);
        $stmt->bindParam('order', $order, PDO::PARAM_INT);
        $stmt->execute();
    }

    /*
    public function getAllTypes()
    {
    if (empty($this->tmptypes)) {
    $this->tmptypes = array(
    1 => array(
    'id' => 1,
    'name' => 'simple',
    'title' => 'Простой'
    ),
    2 => array(
    'id' => 2,
    'name' => 'advanced',
    'title' => 'Advanced'
    )
    );
    }
    return $this->tmptypes;
    }

    public function getType($id)
    {
    return $this->tmptypes[$id];
    }
    */

    private function getObjId()
    {
        $obj_id = systemToolkit::getInstance()->getObjectId($this->section . '_menuItem');
        $this->register($obj_id);
        return $obj_id;
    }

    public function convertArgsToObj($args)
    {
        if ($args['id'] == 0) {
            $obj = $this->create();
            $obj->import(array('obj_id' => $this->getObjId()));
            return $obj;
        }
        $item = $this->searchById($args['id']);

        if ($item) {
            return $item;
        }

        throw new mzzDONotFoundException();
    }
}

?>