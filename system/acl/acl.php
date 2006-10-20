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
 * @version 0.1.1
 */
class acl
{
    /**
     * ��������� ������� ��� ������ � ��
     *
     * @var mzzPdo
     */
    private $db;

    /**
     * ��� ��
     *
     * @var string
     */
    private $class;

    /**
     * ��� �������
     *
     * @var string
     */
    private $section;

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

    private $resultGroups = array();

    /**
     * ������ ��� �������� �������� ������ ��� ����������� �������
     *
     * @var array
     */
    private $validActions = array();
    private $alias;

    /**
     * �����������
     *
     * @param user $user
     * @param integer $object_id
     * @param string_type $class
     * @param string $section
     */
    public function __construct($user = null, $object_id = 0, $class = null, $section = null, $alias = 'default')
    {
        //@todo ��������� �� �������������
        $this->alias = $alias;

        if (empty($user)) {
            $toolkit = systemToolkit::getInstance();
            $user = $toolkit->getUser($this->alias);
        }

        if (!($user instanceof user)) {
            throw new mzzInvalidParameterException('���������� $user �� �������� ���������� ������ user', $user);
        }

        $this->class = $class;
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
     * ������ ���������� ���������������� �� obj_id<br>
     * ������������: uid/groups<br>
     * � ���������� �������� ������ ����:<br>
     * $result[0]['param1'] = 1;<br>
     * $result[0]['param2'] = 0;<br>
     * ��� param1, param2 - ������������� ��������<br>
     * 1/0 - ���������. 1 - ������ ����, 0 - ������� ���<br>
     *
     * @param string|null $param
     * @param boolean $clean ����, ������������ ��� ����� ����� ����������� ��� ������������ �������������, ��� ����� ���� �� ������, � ������� �� �������
     * @return array|bool ������ � ������� | �������/���������� �����
     */
    public function get($param = null, $clean = false)
    {
        if (empty($this->result[$this->obj_id][$clean])) {
            $this->initDb();

            $grp = '';

            foreach ($this->groups as $val) {
                $grp .= $this->db->quote($val) . ', ';
            }
            $grp = substr($grp, 0, -2);

            $qry = 'SELECT MAX(`access`) AS `access`, `name` FROM (

                    (SELECT MIN(`a`.`allow`) AS `access`, `p`.`name` FROM `sys_access` `a`
                                         INNER JOIN `sys_access_classes_sections_actions` `msp` ON `a`.`class_section_action` = `msp`.`id`
                                          INNER JOIN `sys_access_actions` `p` ON `msp`.`action_id` = `p`.`id`
                                           WHERE `a`.`obj_id` = :obj_id AND `a`.`uid` = :uid
                                            GROUP BY `a`.`class_section_action`)';

            if (sizeof($this->groups) && !$clean) {
                $qry .= 'UNION
                                    (SELECT MIN(`a`.`allow`) AS `access`, `p`.`name` FROM `sys_access` `a`
                                     INNER JOIN `sys_access_classes_sections_actions` `msp` ON `a`.`class_section_action` = `msp`.`id`
                                      INNER JOIN `sys_access_actions` `p` ON `msp`.`action_id` = `p`.`id`
                                       WHERE `a`.`obj_id` = :obj_id AND `a`.`gid` IN (' . $grp . ')
                                        GROUP BY `a`.`class_section_action`)';
            }

            $qry .= ') `x`
            GROUP BY `x`.`name`';

            $stmt = $this->db->prepare($qry);

            $this->bind($stmt);

            $stmt->execute();

            $this->result[$this->obj_id][$clean] = array();

            while ($row = $stmt->fetch()) {
                $this->result[$this->obj_id][$clean][$row['name']] = (bool)$row['access'];
            }
        }

        if (empty($param)) {
            return $this->result[$this->obj_id][$clean];
        } else {
            return isset($this->result[$this->obj_id][$clean][$param]) ? (bool)$this->result[$this->obj_id][$clean][$param] : false;
        }
    }

    public function getForGroup($gid)
    {
        if (empty($this->resultGroups[$this->obj_id])) {
            $this->initDb();

            $qry = 'SELECT MIN(`a`.`allow`) AS `access`, `p`.`name` FROM `sys_access` `a`
            INNER JOIN `sys_access_classes_sections_actions` `msp` ON `a`.`class_section_action` = `msp`.`id`
            INNER JOIN `sys_access_actions` `p` ON `msp`.`action_id` = `p`.`id`
            WHERE `a`.`obj_id` = ' . (int)$this->obj_id . ' AND `a`.`gid` = ' . (int)$gid . '
            GROUP BY `a`.`class_section_action`';
            $stmt = $this->db->query($qry);

            $this->resultGroups[$this->obj_id] = array();

            while ($row = $stmt->fetch()) {
                $this->resultGroups[$this->obj_id][$row['name']] = $row['access'];
            }
        }

        return $this->resultGroups[$this->obj_id];
    }

    public function getUsersList()
    {
        $this->initDb();

        $toolkit = systemToolkit::getInstance();
        $userMapper = $toolkit->getMapper('user', 'user', 'user', $this->alias);

        $criteria = new criteria();
        $criteria->addJoin('sys_access', new criterion($userMapper->getTable() . '.' . $userMapper->getTableKey(), 'a.uid', criteria::EQUAL, true), 'a', criteria::JOIN_INNER);
        $criteria->addGroupBy($userMapper->getTable() . '.' . $userMapper->getTableKey());
        $criteria->add('a.obj_id', $this->obj_id);

        return $userMapper->searchAllByCriteria($criteria);
    }

    public function getGroupsList()
    {
        $this->initDb();

        $toolkit = systemToolkit::getInstance();
        $groupMapper = $toolkit->getMapper('user', 'group', 'user', $this->alias);

        $criteria = new criteria();
        $criteria->addJoin('sys_access', new criterion($groupMapper->getTable() . '.' . $groupMapper->getTableKey(), 'a.gid', criteria::EQUAL, true), 'a', criteria::JOIN_INNER);
        $criteria->addGroupBy($groupMapper->getTable() . '.' . $groupMapper->getTableKey());
        $criteria->add('a.obj_id', $this->obj_id);

        return $groupMapper->searchAllByCriteria($criteria);
    }

    /**
     * ����� ��� ��������� ����<br>
     * ������������� ����� ��� �������� �� ������, ��� � ������ �����
     *
     * @param string|array $param ������ � ������ ����������� ��������, ��� ������ � ���� ��
     * @param boolean $value ��������������� ��������
     */
    public function set($param, $value = null, $group_id = 0)
    {
        $this->initDb();

        // �������� ��� ���������� ����� ��� ������� ��
        $qry = 'SELECT DISTINCT `aa`.`name`, `csa2`.`id` FROM `sys_access` `a`
            INNER JOIN `sys_access_classes_sections_actions` `csa` ON `csa`.`id` = `a`.`class_section_action`
            INNER JOIN `sys_access_classes_sections_actions` `csa2` ON `csa2`.`class_section_id` = `csa`.`class_section_id`
            INNER JOIN `sys_access_actions` `aa` ON `aa`.`id` = `csa2`.`action_id`
            WHERE `a`.`obj_id` = ' . $this->obj_id;
        $stmt = $this->db->query($qry);
        $validActions = $stmt->fetchAll();

        foreach ($validActions as $val) {
            $this->validActions[$this->obj_id][$val['name']] = $val['id'];
        }

        if (!isset($this->validActions[$this->obj_id]) || !sizeof($this->validActions[$this->obj_id])) {
            throw new mzzRuntimeException('��������� ������ �� ��������������� � acl');
        }

        if (!is_array($param)) {
            $param = array($param => $value);
        }

        $csa_ids = array();
        $inserts = '';

        foreach ($param as $key => $val) {
            if (!isset($this->validActions[$this->obj_id][$key])) {
                throw new mzzInvalidParameterException('� ���������� ������� ��� ����������� ��������', $key);
            }

            $csa_ids[] = $this->validActions[$this->obj_id][$key];
            $inserts .= '(' . $this->validActions[$this->obj_id][$key] . ', ' . $this->obj_id . ', ' . ($group_id > 0 ? $group_id : $this->uid) . ', ' . (int)$val . '), ';
        }

        // ������� ������ ��������
        if (sizeof($csa_ids)) {
            $qry = 'DELETE FROM `sys_access` WHERE `class_section_action` IN (' . implode(', ', $csa_ids) . ') AND `obj_id` = ' . $this->obj_id . ' AND ';
            $qry .= $group_id > 0 ? '`gid` = ' . $group_id : '`uid` = ' . $this->uid;
            $this->db->query($qry);
        }

        // ��������� �����
        $inserts = substr($inserts, 0, -2);
        if ($inserts) {
            $this->db->query('INSERT INTO `sys_access` (`class_section_action`, `obj_id`, `' . ($group_id > 0 ? 'gid' : 'uid') . '`, `allow`)
                                VALUES ' . $inserts);
        }

        // ������� ���
        unset($this->result[$this->obj_id]);
    }

    public function setForGroup($gid, $param)
    {
        return $this->set($param, null, (int)$gid);
    }

    /**
     * ����� ��� ����������� ������ ������� � ������� �����������<br>
     * ��� ����������� ������ ������� ��� ���� "�����������" ���������� � ������������ �� ���������� ���������:<br>
     * - ����� ���������� ���������� ��� ������� � ����������� ��������� �������, ������, ���� � ������� obj_id = 0<br>
     * - ����� ��������������� �� �������� ������������ ��� �� ��������� ������� ���� ����������� �������
     *   � ������������ ���������� �������, ������, ���� � �������� �������� uid = 0
     *
     * @param integer $obj_id ���������� id ��������������� �������
     * @param string $class ��� ��
     * @param string $section ��� �������
     */
    public function register($obj_id, $class = null, $section = null, $module = null)
    {
        $this->obj_id = (int)$obj_id;

        if ($this->obj_id <= 0) {
            throw new mzzInvalidParameterException('�������� obj_id ������ ���� �������������� ���� � ����� �������� > 0', $this->obj_id);
        }

        if (!empty($class)) {
            $this->class = $class;
        }

        if (!empty($section)) {
            $this->section = $section;
        }

        if (empty($this->class) || !is_string($this->class)) {
            throw new mzzInvalidParameterException('�������� $class �� ����������� ��� ����� ���, �������� �� string', $this->class);
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

        if (!$obj_id) {
            $obj_id = $this->obj_id;
        }

        $this->db->query('DELETE FROM `sys_access` WHERE `obj_id` = ' . (int)$obj_id);
    }

    public function getClass()
    {
        $this->initDb();

        $qry = 'SELECT DISTINCT `c`.`name` FROM `sys_access` `a`
                 INNER JOIN `sys_access_classes_sections_actions` `csa` ON `csa`.`id` = `a`.`class_section_action`
                  INNER JOIN `sys_access_classes_sections` `cs` ON `cs`.`id` = `csa`.`class_section_id`
                   INNER JOIN `sys_access_classes` `c` ON `c`.`id` = `cs`.`class_id`
                    WHERE `obj_id` = ' . $this->obj_id;
        $stmt = $this->db->query($qry);
        $res = $stmt->fetch();
        return $res['name'];
    }

    public function getModule()
    {
        $this->initDb();

        $qry = 'SELECT DISTINCT `m`.`name` FROM `sys_access` `a`
                 INNER JOIN `sys_access_classes_sections_actions` `csa` ON `csa`.`id` = `a`.`class_section_action`
                  INNER JOIN `sys_access_classes_sections` `cs` ON `cs`.`id` = `csa`.`class_section_id`
                   INNER JOIN `sys_access_classes` `c` ON `c`.`id` = `cs`.`class_id`
                    INNER JOIN `sys_access_modules` `m` ON `m`.`id` = `c`.`module_id`
                     WHERE `obj_id` = ' . $this->obj_id;
        $stmt = $this->db->query($qry);
        $res = $stmt->fetch();
        return $res['name'];
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
        return 'SELECT `a`.* FROM `sys_access_classes_sections` `ms`
                 INNER JOIN `sys_access_classes` `m` ON `ms`.`class_id` = `m`.`id` AND `m`.`name` = :class
                  INNER JOIN `sys_access_sections` `s` ON `ms`.`section_id` = `s`.`id` AND `s`.`name` = :section
                   INNER JOIN `sys_access_classes_sections_actions` `msp` ON `msp`.`class_section_id` = `ms`.`id`
                    INNER JOIN `sys_access_actions` `p` ON `p`.`id` = `msp`.`action_id`
                     INNER JOIN `sys_access` `a` ON `a`.`class_section_action` = `p`.`id` AND `a`.`obj_id` = 0';
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
        $qry = 'INSERT INTO `sys_access` (`class_section_action`, `uid`, `gid`, `allow`, `obj_id`) VALUES ';

        $exists = false;
        while($row = $stmt->fetch()) {
            $qry .= "(" . $this->db->quote($row['class_section_action']) . ", "; // . $this->db->quote($row['type']) . ", ";
            if (!$row['uid'] && !$row['gid']) {
                $qry .= $this->db->quote($this->uid) . ', NULL';
            } else {
                $qry .= (($tmp = (int)$row['uid']) > 0 ? $tmp : 'NULL' ). ", " . (($tmp = (int)$row['gid']) > 0 ? $tmp : 'NULL');
            }
            $qry .= ", " . (int)$row['allow'] . ", " . (int)$obj_id . "), ";
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
            $this->db = db::factory($this->alias);
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
        $stmt->bindParam(':class', $this->class);

        if (!empty($obj_id)) {
            if ($obj_id <= 0) {
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