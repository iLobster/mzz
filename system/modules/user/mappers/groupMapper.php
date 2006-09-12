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
 * @package user
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
    protected $tablePostfix = '_group';

    /**
     * �����������
     *
     * @param string $section ������
     */
    public function __construct($section)
    {
        parent::__construct($section);
        $this->relationTable = $this->table . '_rel';
    }

    /**
     * ��������� ����� ������� �� ��������������
     *
     * @param integer $id �������������
     * @return object
     */
    public function searchById($id)
    {
        $row = $this->searchOneByField('id', $id);
        /*var_dump($stmt);
        $row = $stmt->fetch();*/

        if ($row) {
            //return $this->createItemFromRow($row);
            return $row;
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
        return $this->searchOneByField('name', $name);
        /*$stmt = $this->searchByField('name', $name);
        $row = $stmt->fetch();

        if ($row) {
            return $this->createGroupFromRow($row);
        } else {
            return false;
        }*/
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
        $stmt = $this->db->prepare("SELECT * FROM `" . $this->relationTable . "` `rel` INNER JOIN `" . $this->table . "` `gr` ON `rel`.`group_id` = `gr`.`id` WHERE `rel`.`user_id` = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll();

        $result = array();

        foreach ($rows as $row) {
            $row = array(0 => array('group' => $row));
            $result[] = $this->createItemFromRow($row);
        }

        return $result;
    }

    public function getUsers($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM `" . $this->table . "` `gr` INNER JOIN `" . $this->table . "_rel` `rel` ON `gr`.`id` = `rel`.`group_id` WHERE `gr`.`id` = :id");
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
     *//*
    protected function createItemFromRow($row)
    {
        $map = $this->getMap();
        $group = new group($map);

        $f = array();
        foreach ($row as $key => $val) {
            $f[$this->className][str_replace($this->className . '_', '', $key)] = $val;
        }
var_dump($row);
        $group->import($f[$this->className]);
        return $group;
    }*/

}

?>