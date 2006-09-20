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

fileLoader::load('user');
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
     * �������� ����� �������
     *
     * @var string
     */
    //protected $tablePostfix = '_group';

    /**
     * ��������� ����� ������� �� ��������������
     *
     * @param integer $id �������������
     * @return object
     */
    public function searchById($id)
    {
        $stmt = $this->searchByField('id', $id);
        $row = $stmt->fetch();

        if ($row) {
            return $this->createGroupFromRow($row);
        } else {
            // ��� ���?
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
        $stmt = $this->searchByField('name', $name);
        $row = $stmt->fetch();

        if ($row) {
            return $this->createGroupFromRow($row);
        } else {
            return false;
        }
    }

    /**
     * ��������� ����� ������� (��������) ����� �� ��������������
     * � ���� (� ���) ������������
     *
     * @param string $id ������������� ������������
     * @return object|false
     */
    public function searchByUser($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM `" . $this->section() . "_usergroup_rel` `rel` INNER JOIN `" . $this->table . "` `gr` ON `rel`.`group_id` = `gr`.`id` WHERE `rel`.`user_id` = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll();

        $result = array();

        foreach ($rows as $row) {
            $result[] = $this->createGroupFromRow($row);
        }

        return $result;
    }

    public function getUsers($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM `" . $this->table . "` `gr` INNER JOIN `" . $this->section() . "_usergroup_rel` `rel` ON `gr`.`id` = `rel`.`group_id` WHERE `gr`.`id` = :id");

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll();

        $result = array();

        $userMapper = new userMapper('user');

        foreach ($rows as $row) {
            $result[] = $userMapper->searchById($row['user_id']);
        }

        return $result;
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

}

?>