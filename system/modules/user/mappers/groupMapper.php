<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * groupMapper: ������ ��� ����� �������������
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

fileLoader::load('user/group');
fileLoader::load('user/mappers/userMapper');

class groupMapper extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'user';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'group';

    /**
     * ��������� ����� ������� �� ��������������
     *
     * @param integer $id �������������
     * @return object
     */
    public function searchById($id)
    {
        $group = $this->searchOneByField('id', $id);

        if ($group) {
            return $group;
        } else {
            if($id == 1) {
                throw new mzzSystemException('����������� ������ � ID: 1 ��� ����� � ������� ' . $this->table);
            }
            return $this->getGuest();
        }
    }

    /**
     * ��������� ����� ������� �� �����
     *
     * @param string $name ���
     * @return object|false
     */
    public function searchByName($name)
    {
        $group = $this->searchOneByField('name', $name);

        if ($group) {
            return $group;
        } else {
            return false;
        }
    }

    /**
     * ������� ������ group �� �������
     *
     * @param array $row
     * @return object
     */
    protected function createGroupFromRow($row)
    {
        $map = $this->getMap();
        $group = new group($map);
        $group->import($row);
        return $group;
    }

    public function convertArgsToId($args)
    {
        //var_dump($args);
        $newsFolder = $this->getFolderByPath(implode('/', $args));
        return (int)$newsFolder->getObjId();
    }

}

?>