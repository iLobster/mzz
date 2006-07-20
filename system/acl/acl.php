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
     * @var string
     */
    private $section;

    /**
     * ��� �������
     *
     * @var string
     */
    //private $type;

    /**
     * ���������� id �������
     *
     * @var integer
     */
    private $obj_id;

    /**
     * id ������������, � �������� ����� ����������� �����
     *
     * @var integer
     */
    private $uid;

    /**
     * ������ �����, ������� ����������� ������������
     *
     * @var array
     */
    private $groups = array();

    /**
     * ����������, ��� �������� ����������� ��������<br>
     * ��� ����������� � ������ (�������������� ��������� ����������� ��������)
     *
     * @var array
     */
    private $result = array();

    /**
     * �����������
     *
     * @param user $user
     * @param integer $object_id
     * @param string_type $module
     * @param string $section
     */
    public function __construct($user = null, $object_id = 0, $module = null, $section = null)
    {
        if (empty($user)) {
            $toolkit = systemToolkit::getInstance();
            $user = $toolkit->getUser();
        }

        if (!($user instanceof user)) {
            throw new mzzInvalidParameterException('���������� $user �� �������� ���������� ������ user', $user);
        }

        $this->module = $module;
        $this->section = $section;
        //$this->type = $type;
        if (!is_int($object_id)) {
            throw new mzzInvalidParameterException('���������� object_id �� �������� ���������� �������������� ����', $object_id);
        }
        $this->obj_id = $object_id;
        $this->uid = $user->getId();
        $this->groups = $user->getGroupsList();
    }

    /**
     * ����� ��������� ������ ���� �� ��������� ������ � ����������� ������������<br>
     * ������ ���������� ���������������� ������������� ����������: section/module/type/obj_id<br>
     * ������������: uid/groups<br>
     * � ���������� �������� ������ ����:<br>
     * $result[0]['param1'] = 1;<br>
     * $result[0]['param2'] = 0;<br>
     * ��� param1, param2 - ������������� ��������<br>
     * 1/0 - ���������. 1 - ������ ����, 0 - ������� ���<br>
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

            $qry = 'SELECT IF(MAX(`a`.`deny`), 0, MAX(`a`.`allow`)) AS `access`, `p`.`name` FROM `sys_access` `a`
                     INNER JOIN `sys_access_modules_sections_properties` `msp` ON `a`.`module_section_property` = `msp`.`id`
                      INNER JOIN `sys_access_properties` `p` ON `msp`.`property_id` = `p`.`id`
                       WHERE `a`.`obj_id` = :obj_id AND (`a`.`uid` = :uid';

            if (sizeof($this->groups)) {
                $qry .= ' OR `a`.`gid` IN (' . $grp . ')';
            }

            $qry .= ')';

            $qry .= ' GROUP BY `a`.`module_section_property`';

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
     * ����� ��� ����������� ������ ������� � ������� �����������<br>
     * ��� ����������� ������ ������� ��� ���� "�����������" ���������� � ������������ �� ���������� ���������:<br>
     * - ����� ���������� ���������� ��� ������� � ����������� ��������� �������, ������, ���� � ������� obj_id = 0<br>
     * - ����� ��������������� �� �������� ������������ ��� �� ��������� ������� ���� ����������� �������
     *   � ������������ ���������� �������, ������, ���� � �������� �������� uid = 0
     *
     * @param integer $obj_id ���������� id ��������������� �������
     * @param string $module ��� ������
     * @param string $section ��� �������
     */
    public function register($obj_id, $module = null, $section = null)
    {
        $this->obj_id = $obj_id;

        if (!is_int($this->obj_id) || $this->obj_id <= 0) {
            throw new mzzInvalidParameterException('�������� obj_id ������ ���� �������������� ���� � ����� �������� > 0', $this->obj_id);
        }

        if (!empty($module)) {
            $this->module = $module;
        }

        if (!empty($section)) {
            $this->section = $section;
        }

        if (empty($this->module) || !is_string($this->module)) {
            throw new mzzInvalidParameterException('�������� $module �� ����������� ��� ����� ���, �������� �� string', $this->module);
        }

        if (empty($this->section) || !is_string($this->section)) {
            throw new mzzInvalidParameterException('�������� $section �� ����������� ��� ����� ���, �������� �� string', $this->section);
        }

        $this->initDb();

        $qry = $this->getQuery();
        $this->doRoutine($qry, $obj_id);
    }

    /**
     * ����� �������� ������� �� ������� �����������<br>
     * � ������, ���� �������� $obj_id �� ������, ��������� ������� ������
     *
     * @param integer $obj_id ������������� ���������� �������
     */
    public function delete($obj_id = 0)
    {
        $this->initDb();

        $stmt = $this->db->prepare('DELETE FROM `sys_access` WHERE `obj_id` = :obj_id');

        $this->bind($stmt, $obj_id);

        $stmt->execute();
    }

    /**
     * ����� ��������� ������� ��� ��������� �������� � ������� obj_id
     * ��� ������� ������������ ��� �������� ��������� �������� ����
     *
     * @return string
     * @see acl::register()
     */
    private function getQuery()
    {
        return 'SELECT `a`.* FROM `sys_access_modules_sections` `ms`
                 INNER JOIN `sys_access_modules` `m` ON `ms`.`module_id` = `m`.`id` AND `m`.`name` = :module
                  INNER JOIN `sys_access_sections` `s` ON `ms`.`section_id` = `s`.`id` AND `s`.`name` = :section
                   INNER JOIN `sys_access_modules_sections_properties` `msp` ON `msp`.`module_section_id` = `ms`.`id`
                    INNER JOIN `sys_access_properties` `p` ON `p`.`id` = `msp`.`property_id`
                     INNER JOIN `sys_access` `a` ON `a`.`module_section_property` = `p`.`id` AND `a`.`obj_id` = 0';
    }

    /**
     * ����� �� �������� ����������, �������� � ���� ���������� � ����������<br>
     * ���������� ������ ���������� ����� ��� ���������� ������� ������� ���� � ��������������� �������
     *
     * @param string $qry ������ �������
     * @param integer $obj_id ���������� id �������
     * @see acl::register()
     */
    private function doRoutine($qry, $obj_id)
    {
        $stmt = $this->db->prepare($qry);

        $this->bind($stmt, $obj_id);

        $stmt->execute();

        $this->doInsertQuery($stmt, $obj_id);
    }

    /**
     * �����, �������������� ������� � ������� ���� ������� ����
     *
     * @param mzzStatement $stmt
     * @param integer $obj_id ���������� id �������
     * @see acl::doRoutine()
     */
    private function doInsertQuery($stmt, $obj_id)
    {
        $qry = 'INSERT INTO `sys_access` (`module_section_property`, `uid`, `gid`, `allow`, `deny`, `obj_id`) VALUES ';

        $exists = false;
        while($row = $stmt->fetch()) {
            $qry .= "(" . $this->db->quote($row['module_section_property']) . ", "; // . $this->db->quote($row['type']) . ", ";
            if (!$row['uid'] && !$row['gid']) {
                $qry .= $this->db->quote($this->uid) . ', NULL';
            } else {
                $qry .= (($tmp = (int)$row['uid']) > 0 ? $tmp : 'NULL' ). ", " . (($tmp = (int)$row['gid']) > 0 ? $tmp : 'NULL');
            }
            $qry .= ", " . (int)$row['allow'] . ", " . (int)$row['deny'] . ", " . (int)$obj_id . "), ";
            $exists = true;
        }
        $qry = substr($qry, 0, -2);

        if ($exists) {
            $this->db->query($qry);
        }
    }

    /**
     * ����� ������������� ������� ������ � ����� ������<br>
     * ����������� ��� ����������
     *
     * @see acl::get()
     * @see acl::register()
     */
    private function initDb()
    {
        if (empty($this->db)) {
            $this->db = db::factory();
        }
    }

    /**
     * ���� ���� ���������� � ���������
     *
     * @param mzzStatement $stmt
     * @param integer $obj_id
     * @see acl::get()
     * @see acl::doRoutine()
     * @see acl::delete()
     */
    private function bind($stmt, $obj_id = 0)
    {
        $stmt->bindParam(':section', $this->section);
        $stmt->bindParam(':module', $this->module);

        if (!empty($obj_id)) {
            if (!is_int($obj_id) || $obj_id <= 0) {
                throw new mzzInvalidParameterException('�������� obj_id ������ ���� �������������� ���� � ����� �������� > 0', $this->obj_id);
            }
            $stmt->bindParam(':obj_id', $obj_id);
        } else {
            $stmt->bindParam(':obj_id', $this->obj_id);
        }
        $stmt->bindParam(':uid', $this->uid);
    }
}

?>