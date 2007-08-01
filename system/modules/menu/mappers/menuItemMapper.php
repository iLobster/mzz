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
 * itemMapper: ������
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menuItemMapper extends simpleCatalogueMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'menu';

    /**
     * ��� ������ DataObject
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
        //$criteria->addSelectField('MAX(`order`)', 'maxorder')->add('parent_id', (int)$id);
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


    public function changeOrder($id, $direction)
    {
        $item = $this->searchById($id);

        if ($item) {
            $next = $this->searchByOrderAndParent((($direction == 'up') ?$item->getOrder() - 1 : $item->getOrder() + 1), $item->getParent());
            if ($next) {
                $item->setOrder($next->getOrder());
                $next->setOrder($item->getOrder());
                $this->save($next);
            }
            $this->save($item);
        }
    }

    public function delete(menuItem $item)
    {
        $stmt = $this->db->prepare('UPDATE ' . $this->table . ' SET `order` = `order` - 1 WHERE `parent_id` = :parent_id AND `order` > :order');
        $stmt->bindParam('parent_id', $item->getParent(), PDO::PARAM_INT);
        $stmt->bindParam('order', $item->getOrder(), PDO::PARAM_INT);
        $stmt->execute();
        parent::delete($item->getId());
    }

    /*
    public function getAllTypes()
    {
    if (empty($this->tmptypes)) {
    $this->tmptypes = array(
    1 => array(
    'id' => 1,
    'name' => 'simple',
    'title' => '�������'
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
            //throw new Exception('��������, ��� ��� �� �����?');
            //return 672;
            $accessMapper = systemToolkit::getInstance()->getMapper('access', 'access');
            $access = $accessMapper->create();
            $access->import(array('obj_id' => $this->getObjId()));
            return $access;
        }
        $item = $this->searchById($args['id']);

        if ($item) {
            return $item;
        }

        throw new mzzDONotFoundException();
    }
}

?>