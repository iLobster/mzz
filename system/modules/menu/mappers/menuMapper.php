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

fileLoader::load('simple/simpleMapperForTree');
fileLoader::load('menu');

/**
 * menuMapper: ������
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menuMapper extends simpleMapper
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
    protected $className = 'menu';


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
        $criteria->add('menu_id', $menuId)->setOrderByFieldDesc('order');

        $itemMapper = systemToolkit::getInstance()->getMapper('menu', 'item');
        $data = $itemMapper->searchAllByCriteria($criteria);
        $tree = $this->build_tree($data);
        return $tree;
    }

    public function build_tree($tree, $id = 0)
    {
        $result = array();
        foreach ($tree as $key => $val) {
            if ($id == $val->getParent()) {
                unset($tree[$key]);
                $result[$key] = $val;
                $result[$key]->setChildrens($this->build_tree($tree, $key));
            }
        }
        return $result;
    }

    /**
     * ���������� ���������� ��� �� ������������� ������ �� ���������� �������
     *
     * @return integer
     */
    public function convertArgsToId($args)
    {
        return 1;
    }
}

?>