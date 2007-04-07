<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * acl: ����� ����������� �������������
 *
 * @package system
 * @version 0.1.8
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
     * ������ ��� �������� �������� ������ ��� ����������� �������
     *
     * @var array
     */
    private $validActions = array();

    /**
     * ����������, �������� �� ������������ root'��
     *
     * @var boolean
     */
    private $isRoot = false;

    /**
     * ������ ��� ������ � �����
     *
     * @var cache
     */
    private $cache;

    /**
     * �����������
     *
     * @param user $user
     * @param integer $object_id ������������� �������
     * @param string $class ��� ������
     * @param string $section ��� ������
     */
    public function __construct($user = null, $object_id = 0, $class = '', $section = '')
    {
        $this->db = db::factory();
        $toolkit = systemToolkit::getInstance();

        $object_id = (int)$object_id;

        if (empty($user)) {
            $user = $toolkit->getUser();
        }
        //var_dump($this->db->getQueriesNum());
        if (!($user instanceof user)) {
            throw new mzzInvalidParameterException('���������� ������ �� �������� ���������� ������ user', $user);
        }

        $this->class = $class;
        $this->section = $section;

        if (!is_int($object_id)) {
            throw new mzzInvalidParameterException('������������� ������� �� �������������� ����', $object_id);
        }

        $this->obj_id = $object_id;
        $this->uid = $user->getId();

        $this->groups = $user->getGroupsList();

        if (defined('MZZ_ROOT_GID') && array_search(MZZ_ROOT_GID, $this->groups) !== false) {
            $this->isRoot = true;
        }

        $this->cache = $toolkit->getCache();
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
     * @param boolean $full ����, ������������, ����� �� ���������� ���������� �������� �� ��������� "���������/���������" ��� ��������������� �������� ����������
     * @return array|bool ������ � ������� | �������/���������� �����
     */
    public function get($param = null, $clean = false, $full = false)
    {
        $identifier = $this->obj_id;
        $result = $this->cache->load($identifier);

        if (!isset($result[$clean][$full])) {

            $grp = '';

            foreach ($this->groups as $val) {
                $grp .= $this->db->quote($val) . ', ';
            }
            $grp = substr($grp, 0, -2);

            $qry = 'SELECT IFNULL((MAX(`a`.`allow`) - MAX(`a`.`deny`) = 1), 0) AS `access`, IFNULL(MAX(`a`.`allow`), 0) AS `allow`, IFNULL(MAX(`a`.`deny`), 0) AS `deny`, `aa`.`name` FROM `sys_access_registry` `r`
                     INNER JOIN `sys_classes_sections` `cs` ON `cs`.`id` = `r`.`class_section_id`
                      INNER JOIN `sys_classes_actions` `ca` ON `ca`.`class_id` = `cs`.`class_id`
                       INNER JOIN `sys_actions` `aa` ON `aa`.`id` = `ca`.`action_id`
                        LEFT JOIN `sys_access` `a` ON `a`.`obj_id` = `r`.`obj_id` AND `a`.`action_id` = `ca`.`action_id` AND (`a`.`uid` = :uid';


            if (sizeof($this->groups) && !$clean) {
                $qry .= ' OR `a`.`gid` IN (' . $grp . ')';
            }

            $qry .= ') WHERE `r`.`obj_id` = :obj_id
                      GROUP BY `ca`.`id`';

            $stmt = $this->db->prepare($qry);

            $this->bind($stmt);

            $stmt->execute();

            $result[$clean][$full] = array();

            while ($row = $stmt->fetch()) {
                if ($full) {
                    $value = array('allow' => (bool)$row['allow'], 'deny' => (bool)$row['deny']);
                } else {
                    $value = (bool)$row['access'];
                }

                if ($this->isRoot) {
                    $result[$clean][$full][$row['name']] = $full ? array('allow' => true, 'deny' => false) : true;
                } else {
                    $result[$clean][$full][$row['name']] = $value;
                }
            }

            $this->cache->save($identifier, $result);
        }

        if (empty($param)) {
            return $result[$clean][$full];
        } else {
            $access = isset($result[$clean][$full][$param]) ? (bool)$result[$clean][$full][$param] : false;
            return $access || $this->isRoot;
        }
    }

    /**
     * ����� �������� ������ �� ACL
     *
     * @param integer $gid
     */
    public function deleteGroup($gid)
    {
        $gid = (int)$gid;

        if ($gid < 1) {
            throw new mzzRuntimeException("������������� ������ ������ ���� > 0 (gid = '" . $gid . "')");
        }

        $this->db->query('DELETE FROM `sys_access` WHERE `obj_id` = ' . $this->obj_id . ' AND `gid` = ' .  $gid);
    }

    /**
     * ����� �������� ������ �� ������� ACL �� ���������
     *
     * @param integer $gid
     */
    public function deleteGroupDefault($gid)
    {
        $class_section_id = $this->getClassSection();
        $this->db->query('DELETE FROM `sys_access` WHERE `obj_id` = 0 AND `gid` = ' .  (int)$gid . ' AND `class_section_id` = ' . $class_section_id);
    }

    /**
     * ����� �������� ������������ �� ������� ACL �� ���������
     *
     */
    public function deleteDefault()
    {
        $class_section_id = $this->getClassSection();
        $this->db->query('DELETE FROM `sys_access` WHERE `obj_id` = 0 AND `uid` = ' .  (int)$this->uid . ' AND `class_section_id` = ' . $class_section_id);
    }

    /**
     * ����� �������� ������������ �� ������� ACL
     *
     * @param integer $uid
     */
    public function deleteUser($uid)
    {
        $uid = (int)$uid;

        if ($uid < 1) {
            throw new mzzRuntimeException("������������� ������������ ������ ���� > 0 (uid = '" . $uid . "')");
        }

        $this->db->query('DELETE FROM `sys_access` WHERE `obj_id` = ' . $this->obj_id . ' AND `uid` = ' .  $uid);
    }

    /**
     * ��������� ���� ��� ���������� ������
     *
     * @param integer $gid
     * @param boolean $full ����, ������������ � ����� ������� �������� ������ � ����������� (������/�����������)
     * @return array
     */
    public function getForGroup($gid, $full = false)
    {
        $identifier = $this->obj_id . '_groups';
        $result = $this->cache->load($identifier);

        if (!isset($result[$gid][$full])) {

            $qry = 'SELECT (MAX(`a`.`allow`) - MAX(`a`.`deny`) = 1) AS `access`, `a`.`allow`, `a`.`deny`, `aa`.`name`
                     FROM `sys_access` `a`
                       INNER JOIN `sys_actions` `aa` ON `a`.`action_id` = `aa`.`id`
                        WHERE `a`.`obj_id` = ' . (int)$this->obj_id . ' AND `a`.`gid` = ' . (int)$gid . '
                         GROUP BY `aa`.`id`';

            $stmt = $this->db->query($qry);

            $result = array();

            while ($row = $stmt->fetch()) {
                if ($full) {
                    $value = array('allow' => (bool)$row['allow'], 'deny' => (bool)$row['deny']);
                } else {
                    $value = (bool)$row['access'];
                }
                $result[$gid][$full][$row['name']] = $value;
            }

            $this->cache->save($identifier, $result);
        }

        return $result[$gid][$full];
    }

    /**
     * ��������� ���� �� ��������� ��� ���������� ������
     *
     * @param integer $gid
     * @param boolean $full ����, ������������ � ����� ������� �������� ������ � ����������� (������/�����������)
     * @return array
     */
    public function getForGroupDefault($gid, $full = false)
    {
        $qry = "SELECT `sa`.`name`, (`a`.`allow` - `a`.`deny` = 1) as `access`, `a`.`allow`, `a`.`deny` FROM `sys_access` `a`
                   INNER JOIN `sys_classes_sections` `cs` ON `cs`.`id` = `a`.`class_section_id`
                    INNER JOIN `sys_classes` `c` ON (`c`.`id` = `cs`.`class_id`) AND (`c`.`name` = " . $this->db->quote($this->class) . ")
                     INNER JOIN `sys_sections` `s` ON (`s`.`id` = `cs`.`section_id`) AND (`s`.`name` = " . $this->db->quote($this->section) . ")
                      INNER JOIN `sys_actions` `sa` ON `sa`.`id` = `a`.`action_id`
                       INNER JOIN `user_group` `g` ON `g`.`id` = `a`.`gid`
                        WHERE `a`.`obj_id` = '0' AND `a`.`gid` = " . (int)$gid;

        $stmt = $this->db->query($qry);

        $result = array();
        while ($row = $stmt->fetch()) {
            if ($full) {
                $value = array('allow' => (bool)$row['allow'], 'deny' => (bool)$row['deny']);
            } else {
                $value = (bool)$row['access'];
            }
            $result[$row['name']] = $value;
        }

        return $result;
    }

    /**
     * ��������� ������� ACL �� ���������
     *
     * @param boolean $full ����, ������������ � ����� ������� �������� ������ � ����������� (������/�����������)
     * @return array
     */
    public function getDefault($full = false)
    {
        $qry = "SELECT `sa`.`name`, (`a`.`allow` - `a`.`deny` = 1) as `access`, `a`.`allow`, `a`.`deny` FROM `sys_access` `a`
                   INNER JOIN `sys_classes_sections` `cs` ON `cs`.`id` = `a`.`class_section_id`
                    INNER JOIN `sys_classes` `c` ON (`c`.`id` = `cs`.`class_id`) AND (`c`.`name` = " . $this->db->quote($this->class) . ")
                     INNER JOIN `sys_sections` `s` ON (`s`.`id` = `cs`.`section_id`) AND (`s`.`name` = " . $this->db->quote($this->section) . ")
                      INNER JOIN `sys_actions` `sa` ON `sa`.`id` = `a`.`action_id`
                       LEFT JOIN `user_user` `u` ON `u`.`id` = `a`.`uid`
                        WHERE `a`.`obj_id` = '0' AND `a`.`uid` = " . $this->uid;

        $stmt = $this->db->query($qry);

        $result = array();
        while ($row = $stmt->fetch()) {
            if ($full) {
                $value = array('allow' => (bool)$row['allow'], 'deny' => (bool)$row['deny']);
            } else {
                $value = (bool)$row['access'];
            }
            $result[$row['name']] = $value;
        }

        return $result;
    }

    /**
     * ��������� ���� ��� ��������� ����� ������������ �������
     *
     * @param boolean $full ����, ������������ � ����� ������� �������� ������ � ����������� (������/�����������)
     * @return array
     */
    public function getForOwner($full = false)
    {
        $tmp = $this->uid;
        $this->uid = 0;
        $result = $this->getDefault($full);
        $this->uid = $tmp;
        return $result;
    }

    /**
     * ����� ��������� ������ �������������, ��� ������� ����������� ����� ��� ����������� �������
     *
     * @return array
     */
    public function getUsersList()
    {
        $toolkit = systemToolkit::getInstance();
        $userMapper = $toolkit->getMapper('user', 'user', 'user');

        $criteria = new criteria();
        $criteria->addJoin('sys_access', new criterion('user.' . $userMapper->getTableKey(), 'a.uid', criteria::EQUAL, true), 'a', criteria::JOIN_INNER);
        $criteria->addGroupBy('user.' . $userMapper->getTableKey());
        $criteria->add('a.obj_id', $this->obj_id);

        return $userMapper->searchAllByCriteria($criteria);
    }

    /**
     * ����� ��������� ������ �������������, ��� ������� ����������� ����� �� ��������� ��� ����������� ���� �������
     *
     * @param string $section
     * @param string $class
     * @return array
     */
    public function getUsersListDefault($section, $class)
    {
        $toolkit = systemToolkit::getInstance();
        $userMapper = $toolkit->getMapper('user', 'user', 'user');

        $criteria = new criteria();
        $criteria->addJoin('sys_access', new criterion('a.uid', 'user.' . $userMapper->getTableKey(), criteria::EQUAL, true), 'a', criteria::JOIN_INNER);
        $criteria->addJoin('sys_classes_sections', new criterion('cs.id', 'a.class_section_id', criteria::EQUAL, true), 'cs', criteria::JOIN_INNER);

        $criterion_class = new criterion('c.id', 'cs.class_id', criteria::EQUAL, true);
        $criterion_class->addAnd(new criterion('c.name', $class));
        $criteria->addJoin('sys_classes', $criterion_class, 'c', criteria::JOIN_INNER);

        $criterion_section = new criterion('s.id', 'cs.section_id', criteria::EQUAL, true);
        $criterion_section->addAnd(new criterion('s.name', $section));
        $criteria->addJoin('sys_sections', $criterion_section, 's', criteria::JOIN_INNER);

        $criteria->add('a.obj_id', 0);

        $criteria->addGroupBy('user.' . $userMapper->getTableKey());

        return $userMapper->searchAllByCriteria($criteria);
    }

    /**
     * ����� ��������� ������ �����, ��� ������� ����������� ����� ��� ����������� �������
     *
     * @return array
     */
    public function getGroupsList()
    {
        $toolkit = systemToolkit::getInstance();
        $groupMapper = $toolkit->getMapper('user', 'group', 'user');

        $criteria = new criteria();
        $criteria->addJoin('sys_access', new criterion('group.' . $groupMapper->getTableKey(), 'a.gid', criteria::EQUAL, true), 'a', criteria::JOIN_INNER);
        $criteria->addGroupBy('group.' . $groupMapper->getTableKey());
        $criteria->add('a.obj_id', $this->obj_id);

        return $groupMapper->searchAllByCriteria($criteria);
    }

    /**
     * ����� ��������� ������ �����, ��� ������� ����������� ����� �� ��������� ��� ����������� ���� �������
     *
     * @param string $section
     * @param string $class
     * @return array
     */
    public function getGroupsListDefault($section, $class)
    {
        $toolkit = systemToolkit::getInstance();
        $groupMapper = $toolkit->getMapper('user', 'group', 'user');

        $criteria = new criteria();
        $criteria->addJoin('sys_access', new criterion('a.gid', 'group.' . $groupMapper->getTableKey(), criteria::EQUAL, true), 'a', criteria::JOIN_INNER);
        $criteria->addJoin('sys_classes_sections', new criterion('cs.id', 'a.class_section_id', criteria::EQUAL, true), 'cs', criteria::JOIN_INNER);

        $criterion_class = new criterion('c.id', 'cs.class_id', criteria::EQUAL, true);
        $criterion_class->addAnd(new criterion('c.name', $class));
        $criteria->addJoin('sys_classes', $criterion_class, 'c', criteria::JOIN_INNER);

        $criterion_section = new criterion('s.id', 'cs.section_id', criteria::EQUAL, true);
        $criterion_section->addAnd(new criterion('s.name', $section));
        $criteria->addJoin('sys_sections', $criterion_section, 's', criteria::JOIN_INNER);

        $criteria->add('a.obj_id', 0);

        $criteria->addGroupBy('group.' . $groupMapper->getTableKey());

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
        // �������� ��� ���������� ����� ��� ������� ��
        $qry = 'SELECT `a`.`name`, `a`.`id` FROM `sys_access_registry` `r`
                 INNER JOIN `sys_classes_sections` `cs` ON `cs`.`id` = `r`.`class_section_id`
                  INNER JOIN `sys_classes_actions` `ca` ON `ca`.`class_id` = `cs`.`class_id`
                   INNER JOIN `sys_actions` `a` ON `a`.`id` = `ca`.`action_id`
                    WHERE `r`.`obj_id` = ' . $this->obj_id;

        $validActions = $this->db->getAll($qry);

        foreach ($validActions as $val) {
            $this->validActions[$this->obj_id][$val['name']] = $val['id'];
        }

        if (!isset($this->validActions[$this->obj_id]) || !sizeof($this->validActions[$this->obj_id])) {
            throw new mzzRuntimeException('������ � ��������������� ' . $this->obj_id . ' �� ��������������� � acl');
        }

        if (!is_array($param)) {
            $param = array($param => $value);
        }

        $actionsToDelete = array();
        $inserts = '';

        $qry = "SELECT `r`.`class_section_id` FROM `sys_access_registry` `r`
                 WHERE `r`.`obj_id` = " . $this->obj_id;
        $class_section_id = $this->db->getOne($qry);

        foreach ($param as $key => $val) {
            if (!isset($this->validActions[$this->obj_id][$key])) {
                throw new mzzRuntimeException("� ������� " . $this->obj_id . " ��� ����������� �������� '" . $key . "'");
            }

            if (is_array($val)) {
                $allow = (int)$val['allow'];
                $deny = (int)$val['deny'];
            } else {
                $allow = (int)$val;
                $deny = 1 - $allow;
            }

            $actionsToDelete[] = $this->validActions[$this->obj_id][$key];
            $inserts .= '(' . $this->validActions[$this->obj_id][$key] . ', ' . $class_section_id . ', ' . $this->obj_id . ', ' . ($group_id > 0 ? $group_id : $this->uid) . ', ' . $allow . ', ' . $deny . '), ';
        }

        // ������� ������ ��������
        if (sizeof($actionsToDelete)) {
            $qry = 'DELETE FROM `sys_access` WHERE `action_id` IN (' . implode(', ', $actionsToDelete) . ') AND `obj_id` = ' . $this->obj_id . ' AND ';
            $qry .= $group_id > 0 ? '`gid` = ' . $group_id : '`uid` = ' . $this->uid;
            $this->db->query($qry);
        }

        // ��������� �����
        $inserts = substr($inserts, 0, -2);

        if ($inserts) {
            $this->db->query('INSERT INTO `sys_access` (`action_id`, `class_section_id`, `obj_id`, `' . ($group_id > 0 ? 'gid' : 'uid') . '`, `allow`, `deny`)
                                VALUES ' . $inserts);
        }

        // ������� ���
        $this->cache->save($this->obj_id, null);
        //unset($this->result[$this->obj_id]);
    }

    /**
     * ��������� ���� ��� ������
     *
     * @param integer $gid
     * @param array $param
     * @return null
     * @see acl::set()
     */
    public function setForGroup($gid, $param)
    {
        return $this->set($param, null, (int)$gid);
    }

    /**
     * ��������� ���� �� ���������
     *
     * @param integer $gid
     * @param array $param
     * @param boolean $isUser
     */
    public function setDefault($gid, $param, $isUser = false)
    {
        $qry = "SELECT `a`.* FROM `sys_classes_sections` `cs`
                 INNER JOIN `sys_classes` `c` ON `cs`.`class_id` = `c`.`id` AND `c`.`name` = " . $this->db->quote($this->class) . "
                  INNER JOIN `sys_classes_actions` `ca` ON `ca`.`class_id` = `c`.`id`
                   INNER JOIN `sys_actions` `a` ON `a`.`id` = `ca`.`action_id`";

        $validActions = $this->db->getAll($qry);

        foreach ($validActions as $val) {
            $this->validActions[$this->class][$val['name']] = $val['id'];
        }


        $class_section_id = $this->getClassSection();

        $actionsToDelete = array();
        $inserts = '';

        foreach ($param as $key => $val) {
            if (!isset($this->validActions[$this->class][$key])) {
                throw new mzzRuntimeException("� ������ " . $this->class . " ��� ����������� �������� '" . $key . "'");
            }

            if (is_array($val)) {
                $allow = (int)$val['allow'];
                $deny = (int)$val['deny'];
            } else {
                $allow = (int)$val;
                $deny = 1 - $allow;
            }

            $actionsToDelete[] = $this->validActions[$this->class][$key];
            $inserts .= '(' . $this->validActions[$this->class][$key] . ', ' . $class_section_id . ', 0, ' . $gid . ', ' . $allow . ', ' . $deny . '), ';
        }

        // ������� ������ ��������
        if (sizeof($actionsToDelete)) {
            $qry = 'DELETE FROM `sys_access` WHERE `action_id` IN (' . implode(', ', $actionsToDelete) . ') AND `class_section_id` = ' . $class_section_id . ' AND `obj_id` = ' . $this->obj_id . ' AND ';
            $qry .= ($isUser ? '`uid`' : '`gid`') . ' = ' . $gid;
            $this->db->query($qry);
        }

        // ��������� �����
        $inserts = substr($inserts, 0, -2);

        if ($inserts) {
            $this->db->query('INSERT INTO `sys_access` (`action_id`, `class_section_id`, `obj_id`, ' . ($isUser ? '`uid`' : '`gid`') . ', `allow`, `deny`)
                                VALUES ' . $inserts);
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
     * @param string $class ��� ��
     * @param string $section ��� �������
     * @param string $module ��� ������
     */
    public function register($obj_id, $class = null, $section = null, $module = null)
    {
        $this->obj_id = (int)$obj_id;

        if ($this->obj_id < 1) {
            throw new mzzInvalidParameterException('�������� obj_id ������ ���� �������������� ���� �� ��������� > 0', $this->obj_id);
        }

        $id = $this->db->getOne('SELECT COUNT(*) FROM `sys_access_registry` WHERE `obj_id` = ' . $this->obj_id);

        if (!$id) {
            if (empty($class) || !is_string($class)) {
                throw new mzzInvalidParameterException('����� �� ������ ��� ����� ���, �������� �� string', $this->class);
            } else {
                $this->class = $class;
            }

            if (empty($section) || !is_string($section)) {
                throw new mzzInvalidParameterException('������ �� ������� ��� ����� ���, �������� �� string', $this->section);
            } else {
                $this->section = $section;
            }

            if ($this->uid != MZZ_USER_GUEST_ID) {
                $qry = $this->getQuery();
                $this->doRoutine($qry, $obj_id);
            }

            $id = $this->getClassSection($this->class, $this->section);

            $this->db->query('INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) VALUES (' . $this->obj_id . ', ' . $id . ')');
        }
    }

    /**
     * �����, ������������ ��������������� ������ � ACL ��� ���
     *
     * @param integer $obj_id
     * @return boolean
     */
    public function isRegistered($obj_id = null)
    {
        if (is_null($obj_id)) {
            $obj_id = $this->obj_id;
        }

        $stmt = $this->db->prepare('SELECT COUNT(*) AS `cnt` FROM `sys_access_registry` WHERE `obj_id` = :obj_id');
        $stmt->bindParam(':obj_id', $obj_id, PDO::PARAM_INT);
        $res = $stmt->execute();

        $res = $stmt->fetch();
        return (bool)$res['cnt'];
    }

    /**
     * ����� �������� ������� �� ������� �����������<br>
     * � ������, ���� �������� $obj_id �� ������, ��������� ������� ������
     *
     * @param integer $obj_id ������������� ���������� �������
     */
    public function delete($obj_id = 0)
    {
        if (!$obj_id) {
            $obj_id = $this->obj_id;
        }

        $this->db->query('DELETE FROM `sys_access` WHERE `obj_id` = ' . (int)$obj_id);
        $this->db->query('DELETE FROM `sys_access_registry` WHERE `obj_id` = ' . (int)$obj_id);
    }

    /**
     * ����� ��������� ����� ������, ���������� �������� �������� ������� ������
     *
     * @return string
     */
    public function getClass()
    {
        $qry = 'SELECT `c`.`name` FROM `sys_access_registry` `r`
                 INNER JOIN `sys_classes_sections` `cs` ON `cs`.`id` = `r`.`class_section_id`
                  INNER JOIN `sys_classes` `c` ON `c`.`id` = `cs`.`class_id`
                   WHERE `r`.`obj_id` = ' . $this->obj_id;
        return $this->db->getOne($qry);
    }

    /**
     * ����� ��������� ����� ������, �������� ����������� ������� ������
     *
     * @param string $class
     * @return string
     */
    public function getModule($class = false)
    {
        if (!$class) {
            $qry = 'SELECT `m`.`name` FROM `sys_access_registry` `r`
                 INNER JOIN `sys_classes_sections` `cs` ON `cs`.`id` = `r`.`class_section_id`
                  INNER JOIN `sys_classes` `c` ON `c`.`id` = `cs`.`class_id`
                   INNER JOIN `sys_modules` `m` ON `m`.`id` = `c`.`module_id`
                    WHERE `r`.`obj_id` = ' . $this->obj_id;
        } else {
            $qry = 'SELECT `m`.`name` FROM `sys_classes` `c`
                     INNER JOIN `sys_modules` `m` ON `m`.`id` = `c`.`module_id`
                      WHERE `c`.`name` = ' . $this->db->quote($class);
        }

        $module = $this->db->getOne($qry);

        if (is_null($module)) {
            throw new mzzRuntimeException('��������� ������ �� ��������������� � acl');
        }

        return $module;
    }

    /**
     * ����� ��������� �������������� �����-������, ���������������� �������������� ������� �
     * ����������� ������, �������������� � ���������� �������
     *
     * @param string $class
     * @param string $section
     * @return integer
     */
    public function getClassSection($class = false, $section = false)
    {
        if (empty($class)) {
            $class = $this->class;
        }
        if (empty($section)) {
            $section = $this->section;
        }

        $qry = "SELECT `cs`.`id` FROM `sys_classes_sections` `cs`
                 INNER JOIN `sys_classes` `c` ON `c`.`id` = `cs`.`class_id`
                  INNER JOIN `sys_sections` `s` ON `s`.`id` = `cs`.`section_id`
                   WHERE `c`.`name` = " . $this->db->quote($class) . " AND `s`.`name` = " . $this->db->quote($section);
        $id = $this->db->getOne($qry);

        if (is_null($id)) {
            $section_id = $this->db->getOne('SELECT `id` FROM `sys_sections` WHERE `name` = ' . $this->db->quote($section));
            if (is_null($section_id)) {
                $this->db->query('INSERT INTO `sys_sections` (`name`) VALUES (' . $this->db->quote($section) . ')');
                $section_id = $this->db->lastInsertId();
            }

            $class_id = $this->db->getOne('SELECT `id` FROM `sys_classes` WHERE `name` = ' . $this->db->quote($class));

            if (is_null($class_id)) {
                throw new mzzRuntimeException('����� <i>' . $class . '</i> �� ��������������� � acl (� ������� sys_classes)');
            }

            $this->db->query('INSERT INTO `sys_classes_sections` (`class_id`, `section_id`) VALUES (' . $class_id . ', ' . $section_id . ')');
            $id = $this->db->lastInsertId();
        }

        return $id;
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
        return 'SELECT `a`.* FROM `sys_classes_sections` `cs`
                 INNER JOIN `sys_classes` `c` ON `cs`.`class_id` = `c`.`id` AND `c`.`name` = :class
                  INNER JOIN `sys_sections` `s` ON `cs`.`section_id` = `s`.`id` AND `s`.`name` = :section
                   INNER JOIN `sys_classes_actions` `ca` ON `ca`.`class_id` = `c`.`id`
                    INNER JOIN `sys_actions` `aa` ON `aa`.`id` = `ca`.`action_id`
                     INNER JOIN `sys_access` `a` ON `a`.`class_section_id` = `cs`.`id` AND `a`.`action_id` = `aa`.`id`
                      WHERE `a`.`obj_id` = 0';
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

        $this->bind($stmt, true);

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
        $qry = 'INSERT INTO `sys_access` (`action_id`, `class_section_id`, `uid`, `gid`, `allow`, `obj_id`) VALUES ';

        $exists = false;
        while($row = $stmt->fetch()) {
            $qry .= "(" . $row['action_id'] . ', ' . $row['class_section_id'] . ", "; // . $this->db->quote($row['type']) . ", ";
            if (!$row['uid'] && !$row['gid']) {
                $qry .= $this->db->quote($this->uid) . ', NULL';
            } else {
                $qry .= ((int)$row['uid'] > 0 ? (int)$row['uid'] : 'NULL' ). ", " . ((int)$row['gid'] > 0 ? (int)$row['gid'] : 'NULL');
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
     * ������������� ������������� ������������ ������� ��� �������
     *
     * @param integer $obj_id
     */
    public function setObjId($obj_id)
    {
        $this->obj_id = (int)$obj_id;
    }

    /**
     * �������� ���������� � �������������� ������
     *
     * @param mzzStatement $stmt
     * @param boolean $additionArgs
     * @see acl::get()
     * @see acl::doRoutine()
     * @see acl::delete()
     */
    private function bind($stmt, $additionArgs = false)
    {
        if ($additionArgs) {
            $stmt->bindParam(':section', $this->section);
            $stmt->bindParam(':class', $this->class);
        } else {
            if ($this->obj_id < 1) {
                throw new mzzInvalidParameterException('�������� obj_id ������ ���� �������������� ���� � ����� �������� > 0', $this->obj_id);
            }
            $stmt->bindParam(':obj_id', $this->obj_id);
            $stmt->bindParam(':uid', $this->uid);
        }
    }
}

?>