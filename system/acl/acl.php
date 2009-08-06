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
 * acl: класс авторизации пользователей
 *
 * @package system
 * @version 0.2
 */
class acl
{
    /**
     * инстанция объекта для работы с БД
     *
     * @var mzzPdo
     */
    private $db;

    /**
     * имя ДО
     *
     * @var string
     */
    private $class;

    /**
     * уникальный id объекта
     *
     * @var integer
     */
    private $obj_id;

    /**
     * id пользователя, у которого будут проверяться права
     *
     * @var integer
     */
    private $uid;

    /**
     * массив групп, которым принадлежит пользователь
     *
     * @var array
     */
    private $groups = array();

    /**
     * массив для хранения валидных экшнов для конкретного объекта
     *
     * @var array
     */
    private $validActions = array();

    /**
     * определяет, является ли пользователь root'ом
     *
     * @var boolean
     */
    private $isRoot = false;

    /**
     * Объект для работы с кэшем
     *
     * @var cache
     */
    private $cache;

    /**
     * конструктор
     *
     * @param user $user
     * @param integer $object_id идентификатор объекта
     * @param string $class имя класса
     */
    public function __construct($user = null, $object_id = 0, $class = '')
    {
        $this->db = db::factory();
        $toolkit = systemToolkit::getInstance();

        $object_id = (int)$object_id;

        if (empty($user)) {
            $user = $toolkit->getUser();
        }
        //var_dump($this->db->getQueriesNum());
        if (!($user instanceof user)) {
            throw new mzzInvalidParameterException('Полученный объект не является инстанцией класса user', $user);
        }

        $this->class = $class;

        if (!is_int($object_id)) {
            throw new mzzInvalidParameterException('Идентификатор объекта не целочисленного типа', $object_id);
        }

        $this->setObjId($object_id);
        $this->uid = $user->getId();

        $this->groups = $user->getGroups();

        if (defined('MZZ_ROOT_GID') && array_search(MZZ_ROOT_GID, $this->groups->keys()) !== false) {
            $this->isRoot = true;
        }

        $this->cache = $toolkit->getCache('memory');
    }

    /**
     * метод получения списка прав на выбранный объект у конкретного пользователя<br>
     * объект однозначно идентифицируется по obj_id<br>
     * пользователь: uid/groups<br>
     * в результате получаем массив вида:<br>
     * $result[0]['param1'] = 1;<br>
     * $result[0]['param2'] = 0;<br>
     * где param1, param2 - запрашиваемое действие<br>
     * 1/0 - результат. 1 - доступ есть, 0 - доступа нет<br>
     *
     * @param string|null $param
     * @param boolean $clean флаг, обозначающий что права будут извлекаться для пользователя исключительно, без учёта прав на группы, в которых он состоит, и прав по умолчанию
     * @param boolean $full флаг, обозначающий, будет ли информация получаться отдельно по значениям "разрешено/запрещено" или результирующему значению разрешения
     * @return array|bool массив с правами | наличие/отсутствие права
     */
    public function get($param = null, $clean = false, $full = false)
    {
        $identifier = $this->obj_id;
        $cacheKey = 'acl_' . $identifier;
        $result = $this->cache->get($cacheKey);

        if (!isset($result[$clean][$full])) {
            $grp = '';

            foreach ($this->groups->keys() as $val) {
                $grp .= $this->db->quote($val) . ', ';
            }
            $grp = substr($grp, 0, -2);

            $qry = 'SELECT IFNULL((MAX(`allow`) - MAX(`deny`) = 1), 0) AS `access`, IFNULL(MAX(`allow`), 0) AS `allow`, IFNULL(MAX(`deny`), 0) AS `deny`, `name` FROM
            ( (';

            $qry .= 'SELECT `a`.`allow`, `a`.`deny`, `aa`.`name`, `a`.`uid`, `a`.`gid` FROM `' . $this->db->getTablePrefix() . 'sys_access_registry` `r`
                      INNER JOIN `' . $this->db->getTablePrefix() . 'sys_classes_actions` `ca` ON `ca`.`class_id` = `r`.`class_id`
                       INNER JOIN `' . $this->db->getTablePrefix() . 'sys_actions` `aa` ON `aa`.`id` = `ca`.`action_id`
                        LEFT JOIN `' . $this->db->getTablePrefix() . 'sys_access` `a` ON `a`.`obj_id` = `r`.`obj_id` AND `a`.`action_id` = `ca`.`action_id` AND (`a`.`uid` = :uid';

            if (sizeof($this->groups) && !$clean) {
                $qry .= ' OR `a`.`gid` IN (' . $grp . ')';
            }

            $qry .= ') WHERE `r`.`obj_id` = :obj_id';

            $qry .= ')';

            if (!$clean) {
                $qry .= ' UNION ALL (';

                $qry .= 'SELECT a.allow, a.deny, aa.name, a.uid, a.gid FROM `' . $this->db->getTablePrefix() . 'sys_access_registry` `r`
                      INNER JOIN `' . $this->db->getTablePrefix() . 'sys_classes_actions` `ca` ON `ca`.`class_id` = `r`.`class_id`
                       INNER JOIN `' . $this->db->getTablePrefix() . 'sys_actions` `aa` ON `aa`.`id` = `ca`.`action_id`
                        LEFT JOIN `' . $this->db->getTablePrefix() . 'sys_access` `a` ON `a`.`obj_id` = 0 AND `a`.`action_id` = `ca`.`action_id` AND `a`.`class_id` = `r`.`class_id`
                         WHERE `r`.`obj_id` = ' . $this->obj_id . ' AND (`a`.`uid` = ' . $this->uid;

                if (sizeof($this->groups)) {
                    $qry .= ' OR `a`.`gid` IN (' . $grp . ')';
                }

                ')';

                $qry .= '))';
            }

            $qry .= ') `x`

                         GROUP BY `x`.`name`';

            $stmt = $this->db->prepare($qry);

            $this->bind($stmt);

            $stmt->execute();

            $result[$clean][$full] = array();

            while ($row = $stmt->fetch()) {
                if ($full) {
                    $value = array(
                        'allow' => (bool)$row['allow'],
                        'deny' => (bool)$row['deny']);
                } else {
                    $value = (bool)$row['access'];
                }

                if ($this->isRoot && !$clean) {
                    $result[$clean][$full][$row['name']] = $full ? array(
                        'allow' => true,
                        'deny' => false) : true;
                } else {
                    $result[$clean][$full][$row['name']] = $value;
                }
            }

            $this->cache->set($cacheKey, $result);
        }

        if (empty($param)) {
            return $result[$clean][$full];
        } else {
            $access = isset($result[$clean][$full][$param]) ? $result[$clean][$full][$param] : false;
            return $access;
            //return $access || $this->isRoot;
        }
    }

    public function getForClass($class, $action)
    {
        $identifier = $class;
        $cacheKey = 'acl_' . $identifier;
        $result = $this->cache->get($cacheKey);

        if (!$result) {
            $grp = '';

            foreach ($this->groups->keys() as $val) {
                $grp .= $this->db->quote($val) . ', ';
            }
            $grp = substr($grp, 0, -2);

            $qry = 'SELECT IFNULL((MAX(`allow`) - MAX(`deny`) = 1), 0) AS `access`, IFNULL(MAX(`allow`), 0) AS `allow`, IFNULL(MAX(`deny`), 0) AS `deny`, `aa`.`name`
                 FROM `' . $this->db->getTablePrefix() . 'sys_classes` `c`
                  INNER JOIN `' . $this->db->getTablePrefix() . 'sys_classes_actions` `ca` ON `ca`.`class_id` = `c`.`id`
                   INNER JOIN `' . $this->db->getTablePrefix() . 'sys_actions` `aa` ON `aa`.`id` = `ca`.`action_id`
                    LEFT JOIN `' . $this->db->getTablePrefix() . 'sys_access` `a` ON `a`.`obj_id` = 0 AND `a`.`class_id` = `c`.`id` AND `a`.`action_id` = `ca`.`action_id` AND (`a`.`uid` = ' . (int)$this->uid;

            if (sizeof($this->groups)) {
                $qry .= ' OR `a`.`gid` IN (' . $grp . ')';
            }

            $qry .= ') WHERE `c`.`name` = ' . $this->db->quote($class) . '  GROUP BY `aa`.`id`';

            $stmt = $this->db->query($qry);
            while ($row = $stmt->fetch()) {
                $result[$row['name']] = $this->isRoot ? true : $row['access'];
            }

            $this->cache->set($cacheKey, $result);
        }

        return isset($result[$action]) ? $result[$action] : false;
    }

    /**
     * Метод удаления группы из ACL
     *
     * @param integer $gid
     */
    public function deleteGroup($gid)
    {
        $gid = (int)$gid;

        if ($gid < 1) {
            throw new mzzRuntimeException("Идентификатор группы должен быть > 0 (gid = '" . $gid . "')");
        }

        $this->db->query('DELETE FROM `' . $this->db->getTablePrefix() . 'sys_access` WHERE `obj_id` = ' . $this->obj_id . ' AND `gid` = ' . $gid);
    }

    /**
     * Метод удаления группы из списков ACL по умолчанию
     *
     * @param integer $gid
     */
    public function deleteGroupDefault($gid)
    {
        $class_id = $this->getConcreteClass();
        $this->db->query('DELETE FROM `' . $this->db->getTablePrefix() . 'sys_access` WHERE `obj_id` = 0 AND `gid` = ' . (int)$gid . ' AND `class_id` = ' . $class_id);
    }

    /**
     * Метод удаления пользователя из списков ACL по умолчанию
     *
     */
    public function deleteDefault()
    {
        $class_id = $this->getConcreteClass();
        $this->db->query('DELETE FROM `' . $this->db->getTablePrefix() . 'sys_access` WHERE `obj_id` = 0 AND `uid` = ' . (int)$this->uid . ' AND `class_id` = ' . $class_id);
    }

    /**
     * Метод удаления пользователя из списков ACL
     *
     * @param integer $uid
     */
    public function deleteUser($uid)
    {
        $uid = (int)$uid;

        if ($uid < 1) {
            throw new mzzRuntimeException("Идентификатор пользователя должен быть > 0 (uid = '" . $uid . "')");
        }

        $this->db->query('DELETE FROM `' . $this->db->getTablePrefix() . 'sys_access` WHERE `obj_id` = ' . $this->obj_id . ' AND `uid` = ' . $uid);
    }

    /**
     * Получение прав для конкретной группы
     *
     * @param integer $gid
     * @param boolean $full флаг, определяющий в каком формате выдавать массив с результатом (полный/сокращённый)
     * @return array
     */
    public function getForGroup($gid, $full = false)
    {
        $identifier = $this->obj_id . '_groups';
        $cacheKey = 'acl_' . $identifier;
        $result = $this->cache->get($cacheKey);

        if (!isset($result[$gid][$full])) {

            $qry = 'SELECT (MAX(`a`.`allow`) - MAX(`a`.`deny`) = 1) AS `access`, `a`.`allow`, `a`.`deny`, `aa`.`name`
                     FROM `' . $this->db->getTablePrefix() . 'sys_access` `a`
                       INNER JOIN `' . $this->db->getTablePrefix() . 'sys_actions` `aa` ON `a`.`action_id` = `aa`.`id`
                        WHERE `a`.`obj_id` = ' . (int)$this->obj_id . ' AND `a`.`gid` = ' . (int)$gid . '
                         GROUP BY `aa`.`id`';

            $stmt = $this->db->query($qry);

            $result = array();

            while ($row = $stmt->fetch()) {
                if ($full) {
                    $value = array(
                        'allow' => (bool)$row['allow'],
                        'deny' => (bool)$row['deny']);
                } else {
                    $value = (bool)$row['access'];
                }
                $result[$gid][$full][$row['name']] = $value;
            }

            $this->cache->set($cacheKey, $result);
        }

        return $result[$gid][$full];
    }

    /**
     * Получение прав по умолчанию для конкретной группы
     *
     * @param integer $gid
     * @param boolean $full флаг, определяющий в каком формате выдавать массив с результатом (полный/сокращённый)
     * @return array
     */
    public function getForGroupDefault($gid, $full = false)
    {
        $groupMapper = systemToolkit::getInstance()->getMapper('user', 'group');

        $qry = 'SELECT `sa`.`name`, (`a`.`allow` - `a`.`deny` = 1) as `access`, `a`.`allow`, `a`.`deny` FROM `' . $this->db->getTablePrefix() . 'sys_access` `a`
                    INNER JOIN `' . $this->db->getTablePrefix() . 'sys_classes` `c` ON (`c`.`id` = `a`.`class_id`) AND (`c`.`name` = ' . $this->db->quote($this->class) . ')
                      INNER JOIN `' . $this->db->getTablePrefix() . 'sys_actions` `sa` ON `sa`.`id` = `a`.`action_id`
                       INNER JOIN `' . $groupMapper->table() . '` `g` ON `g`.`id` = `a`.`gid`
                        WHERE `a`.`obj_id` = 0 AND `a`.`gid` = ' . (int)$gid;

        $stmt = $this->db->query($qry);

        $result = array();
        while ($row = $stmt->fetch()) {
            if ($full) {
                $value = array(
                    'allow' => (bool)$row['allow'],
                    'deny' => (bool)$row['deny']);
            } else {
                $value = (bool)$row['access'];
            }
            $result[$row['name']] = $value;
        }

        return $result;
    }

    /**
     * Получение списков ACL по умолчанию
     *
     * @param boolean $full флаг, определяющий в каком формате выдавать массив с результатом (полный/сокращённый)
     * @return array
     */
    public function getDefault($full = false)
    {
        $userMapper = systemToolkit::getInstance()->getMapper('user', 'user');

        $qry = 'SELECT `sa`.`name`, (`a`.`allow` - `a`.`deny` = 1) as `access`, `a`.`allow`, `a`.`deny` FROM `' . $this->db->getTablePrefix() . 'sys_access` `a`
                    INNER JOIN `' . $this->db->getTablePrefix() . 'sys_classes` `c` ON (`c`.`id` = `a`.`class_id`) AND (`c`.`name` = ' . $this->db->quote($this->class) . ')
                      INNER JOIN `' . $this->db->getTablePrefix() . 'sys_actions` `sa` ON `sa`.`id` = `a`.`action_id`
                       LEFT JOIN `' . $userMapper->table() . '` `u` ON `u`.`id` = `a`.`uid`
                        WHERE `a`.`obj_id` = 0 AND `a`.`uid` = ' . $this->uid;

        $stmt = $this->db->query($qry);

        $result = array();
        while ($row = $stmt->fetch()) {
            if ($full) {
                $value = array(
                    'allow' => (bool)$row['allow'],
                    'deny' => (bool)$row['deny']);
            } else {
                $value = (bool)$row['access'];
            }
            $result[$row['name']] = $value;
        }

        return $result;
    }

    public function isRoot()
    {
        return $this->isRoot;
    }

    /**
     * Получение прав для владельца вновь создаваемого объекта
     *
     * @param boolean $full флаг, определяющий в каком формате выдавать массив с результатом (полный/сокращённый)
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
     * Метод получения списка пользователей, для которых установлены права для конкретного объекта
     *
     * @return array
     */
    public function getUsersList()
    {
        $toolkit = systemToolkit::getInstance();
        $userMapper = $toolkit->getMapper('user', 'user');

        $criteria = new criteria();
        $criteria->addJoin($this->db->getTablePrefix() . 'sys_access', new criterion($userMapper->table() . '.' . $userMapper->pk(), 'a.uid', criteria::EQUAL, true), 'a', criteria::JOIN_INNER);
        $criteria->addGroupBy($userMapper->table() . '.' . $userMapper->pk());
        $criteria->add('a.obj_id', $this->obj_id);

        return $userMapper->searchAllByCriteria($criteria);
    }

    /**
     * Метод получения списка пользователей, для которых установлены права по умолчанию для конкретного типа объекта
     *
     * @param string $class
     * @return array
     */
    public function getUsersListDefault($class)
    {
        $toolkit = systemToolkit::getInstance();
        $userMapper = $toolkit->getMapper('user', 'user');

        $criteria = new criteria();
        $criteria->addJoin($this->db->getTablePrefix() . 'sys_access', new criterion('a.uid', $userMapper->table() . '.' . $userMapper->pk(), criteria::EQUAL, true), 'a', criteria::JOIN_INNER);

        $criterion_class = new criterion('c.id', 'a.class_id', criteria::EQUAL, true);
        $criterion_class->addAnd(new criterion('c.name', $class));
        $criteria->addJoin($this->db->getTablePrefix() . 'sys_classes', $criterion_class, 'c', criteria::JOIN_INNER);

        $criteria->add('a.obj_id', 0);

        $criteria->addGroupBy($userMapper->table() . '.' . $userMapper->pk());

        return $userMapper->searchAllByCriteria($criteria);
    }

    /**
     * Метод получения списка групп, для которых установлены права для конкретного объекта
     *
     * @return array
     */
    public function getGroupsList()
    {
        $toolkit = systemToolkit::getInstance();
        $groupMapper = $toolkit->getMapper('user', 'group');

        $criteria = new criteria();
        $criteria->addJoin($this->db->getTablePrefix() . 'sys_access', new criterion($groupMapper->table() . '.' . $groupMapper->pk(), 'a.gid', criteria::EQUAL, true), 'a', criteria::JOIN_INNER);
        $criteria->addGroupBy($groupMapper->table() . '.' . $groupMapper->pk());
        $criteria->add('a.obj_id', $this->obj_id);

        return $groupMapper->searchAllByCriteria($criteria);
    }

    /**
     * Метод получения списка групп, для которых установлены права по умолчанию для конкретного типа объекта
     *
     * @param string $class
     * @return array
     */
    public function getGroupsListDefault($class)
    {
        $toolkit = systemToolkit::getInstance();
        $groupMapper = $toolkit->getMapper('user', 'group');

        $criteria = new criteria();
        $criteria->addJoin($this->db->getTablePrefix() . 'sys_access', new criterion('a.gid', $groupMapper->table() . '.' . $groupMapper->pk(), criteria::EQUAL, true), 'a', criteria::JOIN_INNER);

        $criterion_class = new criterion('c.id', 'a.class_id', criteria::EQUAL, true);
        $criterion_class->addAnd(new criterion('c.name', $class));
        $criteria->addJoin('sys_classes', $criterion_class, 'c', criteria::JOIN_INNER);

        $criteria->add('a.obj_id', 0);

        $criteria->addGroupBy($groupMapper->table() . '.' . $groupMapper->pk());

        return $groupMapper->searchAllByCriteria($criteria);
    }

    /**
     * Метод для установки прав<br>
     * устанавливать можно как свойства по одному, так и группу сразу
     *
     * @param string|array $param строка с именем изменяемого действия, или массив с ними же
     * @param boolean $value устанавливаемое значение
     */
    public function set($param, $value = null, $group_id = 0)
    {
        // выбираем все корректные экшны для данного ДО
        $qry = 'SELECT `a`.`name`, `a`.`id` FROM `' . $this->db->getTablePrefix() . 'sys_access_registry` `r`
                  INNER JOIN `' . $this->db->getTablePrefix() . 'sys_classes_actions` `ca` ON `ca`.`class_id` = `r`.`class_id`
                   INNER JOIN `' . $this->db->getTablePrefix() . 'sys_actions` `a` ON `a`.`id` = `ca`.`action_id`
                    WHERE `r`.`obj_id` = ' . $this->obj_id;

        $validActions = $this->db->getAll($qry);

        foreach ($validActions as $val) {
            $this->validActions[$this->obj_id][$val['name']] = $val['id'];
        }

        if (!isset($this->validActions[$this->obj_id]) || !sizeof($this->validActions[$this->obj_id])) {
            throw new mzzRuntimeException('Объект с идентификатором ' . $this->obj_id . ' не зарегистрирован в acl');
        }

        if (!is_array($param)) {
            $param = array(
                $param => $value);
        }

        $actionsToDelete = array();
        $inserts = '';

        $qry = 'SELECT `r`.`class_id` FROM `' . $this->db->getTablePrefix() . 'sys_access_registry` `r`
                 WHERE `r`.`obj_id` = ' . $this->obj_id;
        $class_id = $this->db->getOne($qry);

        foreach ($param as $key => $val) {
            if (!isset($this->validActions[$this->obj_id][$key])) {
                throw new mzzRuntimeException("У объекта " . $this->obj_id . " нет изменяемого действия '" . $key . "'");
            }

            if (is_array($val)) {
                $allow = (int)$val['allow'];
                $deny = (int)$val['deny'];
            } else {
                $allow = (int)$val;
                $deny = 1 - $allow;
            }

            $actionsToDelete[] = $this->validActions[$this->obj_id][$key];
            if ($allow || $deny) {
                $inserts .= '(' . $this->validActions[$this->obj_id][$key] . ', ' . $class_id . ', ' . $this->obj_id . ', ' . ($group_id > 0 ? $group_id : $this->uid) . ', ' . $allow . ', ' . $deny . '), ';
            }
        }

        // удаляем старые действия
        if (sizeof($actionsToDelete)) {
            $qry = 'DELETE FROM `' . $this->db->getTablePrefix() . 'sys_access` WHERE `action_id` IN (' . implode(', ', $actionsToDelete) . ') AND `obj_id` = ' . $this->obj_id . ' AND ';
            $qry .= $group_id > 0 ? '`gid` = ' . $group_id : '`uid` = ' . $this->uid;
            $this->db->query($qry);
        }

        // добавляем новые
        $inserts = substr($inserts, 0, -2);

        if ($inserts) {
            $this->db->query('INSERT INTO `' . $this->db->getTablePrefix() . 'sys_access` (`action_id`, `class_id`, `obj_id`, `' . ($group_id > 0 ? 'gid' : 'uid') . '`, `allow`, `deny`)
                                VALUES ' . $inserts);
        }

        // удаляем кэш
        $this->cache->set('acl_' . $this->obj_id, null);
        //unset($this->result[$this->obj_id]);
    }

    /**
     * Установка прав для группы
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
     * Установка прав по умолчанию
     *
     * @param integer $gid
     * @param array $param
     * @param boolean $isUser
     */
    public function setDefault($gid, $param, $isUser = false)
    {
        $qry = 'SELECT `a`.* FROM `' . $this->db->getTablePrefix() . 'sys_classes` `c`
                  INNER JOIN `' . $this->db->getTablePrefix() . 'sys_classes_actions` `ca` ON `ca`.`class_id` = `c`.`id`
                   INNER JOIN `' . $this->db->getTablePrefix() . 'sys_actions` `a` ON `a`.`id` = `ca`.`action_id`
                    WHERE `c`.`name` = ' . $this->db->quote($this->class);

        $validActions = $this->db->getAll($qry);

        foreach ($validActions as $val) {
            $this->validActions[$this->class][$val['name']] = $val['id'];
        }

        $class_id = $this->getConcreteClass();

        $actionsToDelete = array();
        $inserts = '';

        foreach ($param as $key => $val) {
            if (!isset($this->validActions[$this->class][$key])) {
                throw new mzzRuntimeException("У класса " . $this->class . " нет изменяемого действия '" . $key . "'");
            }

            if (is_array($val)) {
                $allow = (int)$val['allow'];
                $deny = (int)$val['deny'];
            } else {
                $allow = (int)$val;
                $deny = 1 - $allow;
            }

            $actionsToDelete[] = $this->validActions[$this->class][$key];
            if ($allow || $deny) {
                $inserts .= '(' . $this->validActions[$this->class][$key] . ', ' . $class_id . ', 0, ' . $gid . ', ' . $allow . ', ' . $deny . '), ';
            }
        }

        // удаляем старые действия
        if (sizeof($actionsToDelete)) {
            $qry = 'DELETE FROM `' . $this->db->getTablePrefix() . 'sys_access` WHERE `action_id` IN (' . implode(', ', $actionsToDelete) . ') AND `class_id` = ' . $class_id . ' AND `obj_id` = ' . $this->obj_id . ' AND ';
            $qry .= ($isUser ? '`uid`' : '`gid`') . ' = ' . $gid;
            $this->db->query($qry);
        }

        // добавляем новые
        $inserts = substr($inserts, 0, -2);

        if ($inserts) {
            $this->db->query('INSERT INTO `' . $this->db->getTablePrefix() . 'sys_access` (`action_id`, `class_id`, `obj_id`, ' . ($isUser ? '`uid`' : '`gid`') . ', `allow`, `deny`)
                                VALUES ' . $inserts);
        }
    }

    /**
     * метод для регистрации нового объекта в системе авторизации<br>
     * при регистрации нового объекта для него "наследуются" разрешения в соответствии со следующими правилами:<br>
     * - права безусловно копируются для объекта с аналогичным значением раздела, модуля, типа и имеющим obj_id = 0<br>
     * - права устанавливаются на текущего пользователя как на создателя объекта путём копирования объекта
     *   с аналогичными значениями раздела, модуля, типа и имеющими значение uid = 0
     *
     * @param integer $obj_id уникальный id регистрируемого объекта
     * @param string $class имя ДО
     */
    public function register($obj_id, $class = null)
    {
        $this->setObjId($obj_id);

        if ($this->obj_id < 1) {
            throw new mzzInvalidParameterException('Свойство obj_id должно быть целочисленного типа со значением > 0', $this->obj_id);
        }

        $id = $this->db->getOne('SELECT COUNT(*) FROM `' . $this->db->getTablePrefix() . 'sys_access_registry` WHERE `obj_id` = ' . $this->obj_id);

        if (!$id) {
            if (empty($class) || !is_string($class)) {
                throw new mzzInvalidParameterException('Класс не указан или имеет тип, отличный от string', $this->class);
            } else {
                $this->class = $class;
            }

            if ($this->uid != MZZ_USER_GUEST_ID) {
                $qry = $this->getQuery();
                $this->doRoutine($qry, $obj_id);
            }

            $id = $this->getConcreteClass($this->class);

            $this->db->query('INSERT INTO `' . $this->db->getTablePrefix() . 'sys_access_registry` (`obj_id`, `class_id`) VALUES (' . $this->obj_id . ', ' . $id . ')');
        }
    }

    /**
     * метод, возвращающий зарегистрирован объект в ACL или нет
     *
     * @param integer $obj_id
     * @return boolean
     */
    public function isRegistered($obj_id = null)
    {
        if (is_null($obj_id)) {
            $obj_id = $this->obj_id;
        }

        $stmt = $this->db->prepare('SELECT COUNT(*) AS `cnt` FROM `' . $this->db->getTablePrefix() . 'sys_access_registry` WHERE `obj_id` = :obj_id');
        $stmt->bindParam(':obj_id', $obj_id, PDO::PARAM_INT);
        $res = $stmt->execute();

        $res = $stmt->fetch();
        return (bool)$res['cnt'];
    }

    /**
     * метод удаления объекта из системы авторизации<br>
     * в случае, если аргумент $obj_id не указан, удаляется текущий объект
     *
     * @param integer $obj_id идентификатор удаляемого объекта
     */
    public function delete($obj_id = 0)
    {
        if (!$obj_id) {
            $obj_id = $this->obj_id;
        }

        $this->db->query('DELETE FROM `' . $this->db->getTablePrefix() . 'sys_access` WHERE `obj_id` = ' . (int)$obj_id);
        $this->db->query('DELETE FROM `' . $this->db->getTablePrefix() . 'sys_access_registry` WHERE `obj_id` = ' . (int)$obj_id);
    }

    /**
     * Метод получения имени класса, инстанцией которого является текущий объект
     *
     * @return string
     */
    public function getClass()
    {
        $qry = 'SELECT `c`.`name` FROM `' . $this->db->getTablePrefix() . 'sys_access_registry` `r`
                  INNER JOIN `' . $this->db->getTablePrefix() . 'sys_classes` `c` ON `c`.`id` = `r`.`class_id`
                   WHERE `r`.`obj_id` = ' . $this->obj_id;
        return $this->db->getOne($qry);
    }

    /**
     * Метод получения имени модуля, которому принадлежит текущий объект
     *
     * @param string $class
     * @return string
     */
    public function getModule($class = false)
    {
        if (!$class) {
            $qry = 'SELECT `m`.`name` FROM `' . $this->db->getTablePrefix() . 'sys_access_registry` `r`
                  INNER JOIN `' . $this->db->getTablePrefix() . 'sys_classes` `c` ON `c`.`id` = `r`.`class_id`
                   INNER JOIN `' . $this->db->getTablePrefix() . 'sys_modules` `m` ON `m`.`id` = `c`.`module_id`
                    WHERE `r`.`obj_id` = ' . $this->obj_id;
        } else {
            $qry = 'SELECT `m`.`name` FROM `' . $this->db->getTablePrefix() . 'sys_classes` `c`
                     INNER JOIN `' . $this->db->getTablePrefix() . 'sys_modules` `m` ON `m`.`id` = `c`.`module_id`
                      WHERE `c`.`name` = ' . $this->db->quote($class);
        }

        $module = $this->db->getOne($qry);

        if (is_null($module)) {
            throw new mzzRuntimeException('Требуемый объект не зарегистрирован в acl');
        }

        return $module;
    }

    /**
     * Метод получения идентификатора класс-секция, характеризующего принадлежность объекта к
     * конкретному классу, расположенному в конкретном разделе
     *
     * @param string $class
     * @return integer
     */
    public function getConcreteClass($class = false)
    {
        if (empty($class)) {
            $class = $this->class;
        }

        $id = $this->db->getOne('SELECT `id` FROM `' . $this->db->getTablePrefix() . 'sys_classes` WHERE `name` = ' . $this->db->quote($class));

        if (is_null($id)) {
            throw new mzzRuntimeException('Класс <i>' . $class . '</i> не зарегистрирован в acl (в таблице sys_classes)');
        }

        return $id;
    }

    /**
     * метод получения запроса для получения объектов с нулевым obj_id
     * эти объекты используются для указания дефолтных значений прав
     *
     * @return string
     * @see acl::register()
     */
    private function getQuery()
    {
        return 'SELECT `a`.* FROM `' . $this->db->getTablePrefix() . 'sys_classes` `c`
                   INNER JOIN `' . $this->db->getTablePrefix() . 'sys_classes_actions` `ca` ON `ca`.`class_id` = `c`.`id`
                    INNER JOIN `' . $this->db->getTablePrefix() . 'sys_actions` `aa` ON `aa`.`id` = `ca`.`action_id`
                     INNER JOIN `' . $this->db->getTablePrefix() . 'sys_access` `a` ON `a`.`class_id` = `c`.`id` AND `a`.`action_id` = `aa`.`id`
                      WHERE `a`.`obj_id` = 0 AND `a`.`uid` = 0';
    }

    /**
     * метод по созданию стейтмента, передаче в него параметров и выполнения<br>
     * полученные данные передаются далее для выполнения запроса вставки прав в соответствующую таблицу
     *
     * @param string $qry строка запроса
     * @param integer $obj_id уникальный id объекта
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
     * метод, осуществляющий вставку в таблицу прав записей прав
     *
     * @param mzzStatement $stmt
     * @param integer $obj_id уникальный id объекта
     * @see acl::doRoutine()
     */
    private function doInsertQuery($stmt, $obj_id)
    {
        $qry = 'INSERT INTO `' . $this->db->getTablePrefix() . 'sys_access` (`action_id`, `class_id`, `uid`, `gid`, `allow`, `obj_id`) VALUES ';

        $exists = false;
        while ($row = $stmt->fetch()) {
            $qry .= "(" . $row['action_id'] . ', ' . $row['class_id'] . ", "; // . $this->db->quote($row['type']) . ", ";
            if (!$row['uid'] && !$row['gid']) {
                $qry .= $this->db->quote($this->uid) . ', NULL';
            } else {
                $qry .= ((int)$row['uid'] > 0 ? (int)$row['uid'] : 'NULL') . ", " . ((int)$row['gid'] > 0 ? (int)$row['gid'] : 'NULL');
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
     * Устанавливает идентификатор проверяемого объекта как текущий
     *
     * @param integer $obj_id
     */
    public function setObjId($obj_id)
    {
        $this->obj_id = (int)$obj_id;
    }

    /**
     * Привязка переменных в подготовленный запрос
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
            $stmt->bindParam(':class', $this->class);
        } else {
            if ($this->obj_id < 1) {
                throw new mzzInvalidParameterException('Свойство obj_id должно быть целочисленного типа и иметь значение > 0', $this->obj_id);
            }
            $stmt->bindParam(':obj_id', $this->obj_id, PDO::PARAM_INT);
            $stmt->bindParam(':uid', $this->uid, PDO::PARAM_INT);
        }
    }

    public function renameAction($class_id, $old_name, $new_id)
    {
        $old_action_id = $this->db->getOne('SELECT `id` FROM `' . $this->db->getTablePrefix() . 'sys_actions` WHERE `name` = ' . $this->db->quote($old_name));

        $this->db->query('UPDATE `' . $this->db->getTablePrefix() . 'sys_access` SET `action_id` = ' . (int)$new_id . ' WHERE `action_id` = ' . $old_action_id . ' AND `class_id` = ' . (int)$class_id);
    }

    public function deleteAction($class_id, $action_id)
    {
        $this->db->query('DELETE FROM `' . $this->db->getTablePrefix() . 'sys_access` WHERE `action_id` = ' . (int)$action_id . ' AND `class_id` = ' . (int)$class_id);
    }
}

?>
