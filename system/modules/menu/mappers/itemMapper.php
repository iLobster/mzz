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
fileLoader::load('menu/item');

/**
 * itemMapper: ������
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class itemMapper extends simpleCatalogueMapper
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
    protected $className = 'item';

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