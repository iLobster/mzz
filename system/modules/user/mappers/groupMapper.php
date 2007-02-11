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
        return $this->searchOneByField('id', $id);
    }

    /**
     * ��������� ����� ������� �� �����
     *
     * @param string $name ���
     * @return object|false
     */
    public function searchByName($name)
    {
        return $this->searchOneByField('name', $name);
    }

    public function convertArgsToId($args)
    {
        if (sizeof($args) == 0) {
            $toolkit = systemToolkit::getInstance();
            $obj_id = $toolkit->getObjectId($this->section . '_groupFolder');
            $this->register($obj_id);
            return $obj_id;
        }

        //return 1;
        $group = $this->searchOneByField('id', $args['id']);
        return (int)$group->getObjId();
    }

}

?>