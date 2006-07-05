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
 * acl: ����� ����������� �������������
 *
 * @package system
 * @version 0.1
 */
class acl
{
    /**
     * ��������� ������� ��� ������ � ��
     *
     * @var object
     */
    private $db;

    /**
     * ��� ������
     *
     * @var string
     */
    private $module;

    /**
     * ��� �������
     *
     * @var unknown_type
     */
    private $section;

    /**
     * ��� �������
     *
     * @var unknown_type
     */
    private $type;

    /**
     * ���������� id �������
     *
     * @var integer
     */
    private $obj_id;

    /**
     * id ������������, � �������� ����� ����������� �����
     *
     * @var unknown_type
     */
    private $uid;

    /**
     * ������ �����, ������� ����������� ������������
     *
     * @var array
     */
    private $groups = array();

    /**
     * ����������, ��� �������� ����������� ��������
     * ��� ����������� � ������ (�������������� ��������� ����������� ��������)
     *
     * @var array
     */
    private $result = array();

    /**
     * �����������
     *
     * @param string $module
     * @param string $section
     * @param string $type
     * @param user $user
     * @param integer $object_id
     */
    public function __construct($module, $section, $type, $user, $object_id = 0)
    {
        $this->module = $module;
        $this->section = $section;
        $this->type = $type;
        $this->obj_id = $object_id;
        $this->uid = $user->getId();
        $this->groups = $user->getGroupsId();
    }

    /**
     * ����� ��������� ������ ���� �� ��������� ������ � ����������� ������������
     * ������ ���������� ���������������� ������������� ����������: section/module/type/obj_id
     * ������������: uid/groups
     * � ���������� �������� ������ ����:
     * $result[0]['param1'] = 1;
     * $result[0]['param2'] = 0;
     * ��� param1, param2 - ������������� ��������
     * 1/0 - ���������. 1 - ������ ����, 0 - ������� ���
     *
     * @param string|null $param
     * @return array|bool ������ � ������� | �������/���������� �����
     */
    public function get($param = null)
    {
        if (empty($this->result[$this->obj_id])) {
            $this->initDb();

            $grp = '';

            foreach ($this->groups as $val) {
                $grp .= $this->db->quote($val) . ', ';
            }
            $grp = substr($grp, 0, -2);

            $qry = 'SELECT IF(MAX(`a`.`deny`), 0, MAX(`a`.`allow`)) AS `access`, `p`.`name` FROM `sys_access_modules` `m`
            INNER JOIN `sys_access_modules_list` `ml` ON `ml`.`id` = `m`.`module_id` AND `ml`.`name` = :module
            INNER JOIN `sys_access_modules_properties` `mp` ON `m`.`id` = `mp`.`module_id` AND `m`.`section` = :section
            INNER JOIN `sys_access_properties` `p` ON `mp`.`property_id` = `p`.`id`
            INNER JOIN `sys_access` `a` ON `a`.`module_property` = `mp`.`id`  AND `a`.`obj_id` = :obj_id AND `a`.`type` = :type
            WHERE `a`.`uid` = :uid ';
            if (sizeof($this->groups)) {
                $qry .= ' OR `a`.`gid` IN (' . $grp . ')';
            }
            $qry .= ' GROUP BY `a`.`module_property`';

            $stmt = $this->db->prepare($qry);

            $this->bind($stmt);

            $stmt->execute();

            $this->result[$this->obj_id] = array();

            while ($row = $stmt->fetch()) {
                $this->result[$this->obj_id][$row['name']] = $row['access'];
            }
        }

        if (empty($param)) {
            return $this->result[$this->obj_id];
        } else {
            return isset($this->result[$this->obj_id][$param]) ? (bool)$this->result[$this->obj_id][$param] : false;
        }
    }

    /**
     * ����� ��� ����������� ������ ������� � ������� �����������
     * ��� ����������� ������ ������� ��� ���� "�����������" ���������� � ������������ �� ���������� ���������:
     * - ����� ���������� ���������� ��� ������� � ����������� ��������� �������, ������, ���� � ������� obj_id = 0
     * - ����� ��������������� �� �������� ������������ ��� �� ��������� ������� ���� ����������� �������
     *   � ������������ ���������� �������, ������, ���� � �������� �������� uid = 0
     *
     * @param integer $obj_id ���������� id ��������������� �������
     */
    public function register($obj_id)
    {
        $this->initDb();

        $qry = 'SELECT `a`.* FROM `sys_access_modules` `m`
        INNER JOIN `sys_access_modules_list` `ml` ON `m`.`module_id` = `ml`.`id` AND `ml`.`name` = :module
        INNER JOIN `sys_access_modules_properties` `mp` ON `mp`.`module_id` = `m`.`id`
        INNER JOIN `sys_access` `a` ON `a`.`module_property` = `mp`.`id` AND `a`.`type` = :type AND `a`.`obj_id` = 0
        WHERE `m`.`section` = :section';

        $stmt = $this->db->prepare($qry);

        $this->bind($stmt);

        $stmt->execute();

        $qry = 'INSERT INTO `sys_access` (`module_property`, `type`, `uid`, `gid`, `allow`, `deny`, `obj_id`) VALUES ';

        $exists = false;
        while($row = $stmt->fetch()) {
            $qry .= "(" . $this->db->quote($row['module_property']) . ", " . $this->db->quote($row['type']) . ", " . $this->db->quote($row['uid']) . ", " . $this->db->quote($row['gid']) . ", " . $this->db->quote($row['allow']) . ", " . $this->db->quote($row['deny']) . ", " . $this->db->quote($obj_id) . "), ";
            $exists = true;
        }
        $qry = substr($qry, 0, -2);

        if ($exists) {
            $this->db->query($qry);
        }
    }

    /**
     * ����� ������������� ������� ������ � ����� ������
     * ����������� ��� ����������
     *
     */
    private function initDb()
    {
        if (empty($this->db)) {
            $this->db = db::factory();
        }
    }

    private function bind($stmt)
    {
        $stmt->bindParam(':section', $this->section);
        $stmt->bindParam(':module', $this->module);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':obj_id', $this->obj_id);
        $stmt->bindParam(':uid', $this->uid);
    }
}

?>