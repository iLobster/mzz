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

fileLoader::load('db/dbTreeNS');
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

    public function getChildrensById($id)
    {
        $criteria = new criteria;
        $criteria->add('parent_id', $id)->setOrderByFieldDesc('order')->setOrderByFieldDesc('id');

        $data = $this->searchAllByCriteria($criteria);
        return $data;
    }

    public function getMaxOrder($id)
    {
        $db = DB::factory();
        $criteria = new criteria($this->table);
        $criteria->addSelectField(new sqlFunction('MAX', 'order', true), 'maxorder')->add('parent_id', (int)$id);
        $select = new simpleSelect($criteria);
        $stmt = $db->query($select->toString());
        $maxorder = $stmt->fetch();
        return (int)$maxorder['maxorder'];
    }

    public function searchByOrderAndParent($order, $parent)
    {
        $criteria = new criteria;
        $criteria->add('order', (int)$order)->add('parent_id', (int)$parent);
        return $this->searchOneByCriteria($criteria);
    }


    public function move(menuItem $item, $target)
    {
        if ($target == 'up' || $target == 'down') {
            $item = $this->changeOrder($item, $target);
        } else {
            $item = $this->changeParent($item, $target);
        }

        $this->save($item);
    }

    protected function changeOrder(menuItem $item, $target)
    {
        $next = $this->searchByOrderAndParent((($target == 'up') ? $item->getOrder() - 1 : $item->getOrder() + 1), $item->getParent());
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

            $item->setOrder($this->getMaxOrder($target) + 1);
            $item->setParent($target);
        }

        return $item;
    }

    public function delete(menuItem $item)
    {
        $childrens = $this->getChildrensById($item->getId());
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