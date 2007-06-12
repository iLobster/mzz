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

    public function searchByName($folder_id)
    {
        return $this->searchOneByField('name', $id);
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