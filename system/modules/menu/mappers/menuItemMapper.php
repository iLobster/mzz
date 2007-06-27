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
        $criteria->add('parent_id', $id)->setOrderByFieldDesc('order');

        $data = $this->searchAllByCriteria($criteria);
        return $data;
    }

    public function getMaxOrder($id)
    {
        $db = DB::factory();
        $criteria = new criteria($this->table);
        $criteria->addSelectField('MAX(`order`)', 'maxorder')->add('parent_id', (int)$id);
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

    /**
     * Возвращает уникальный для ДО идентификатор исходя из аргументов запроса
     *
     * @return integer
     */
    public function convertArgsToId($args)
    {
        if ($args['id'] == 0) {
            return 672;
        }
        $item = $this->searchById($args['id']);

        if ($item) {
            return (int)$item->getObjId();
        }

        throw new mzzDONotFoundException();
    }
}

?>