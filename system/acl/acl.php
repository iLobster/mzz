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
 * acl: класс авторизации пользователей
 *
 * @package system
 * @version 0.1.1
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
     * имя раздела
     *
     * @var string
     */
    private $section;

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
     * переменная, для хранения результатов запросов<br>
     * для кеширования в памяти (предотвращение повторных аналогичных запросов)
     *
     * @var array
     */
    private $result = array();

    private $resultGroups = array();

    /**
     * массив для хранения валидных экшнов для конкретного объекта
     *
     * @var array
     */
    private $validActions = array();
    private $alias;

    /**
     * конструктор
     *
     * @param user $user
     * @param integer $object_id
     * @param string_type $class
     * @param string $section
     */
    public function __construct($user = null, $object_id = 0, $class = null, $section = null, $alias = 'default')
    {
        //@todo проверить на существование
        $this->alias = $alias;

        if (empty($user)) {
            $toolkit = systemToolkit::getInstance();
            $user = $toolkit->getUser($this->alias);
        }

        if (!($user instanceof user)) {
            throw new mzzInvalidParameterException('Переменная $user не является инстанцией класса user', $user);
        }

        $this->class = $class;
        $this->section = $section;
        //$this->type = $type;
        if (!is_int($object_id)) {
            throw new mzzInvalidParameterException('Переменная object_id не является переменной целочисленного типа', $object_id);
        }
        $this->obj_id = $object_id;
        $this->uid = $user->getId();
        $this->groups = $user->getGroupsList();

        $this->db = db::factory($this->alias);
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
     * @param boolean $clean флаг, обозначающий что права будут извлекаться для пользователя исключительно, без учёта прав на группы, в которых он состоит
     * @return array|bool массив с правами | наличие/отсутствие права
     */
    public function get($param = null, $clean = false)
    {
        if (empty($this->result[$this->obj_id][$clean])) {

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

    public function deleteGroup($gid)
    {
        $gid = (int)$gid;

        if ($gid <= 0) {
            throw new mzzRuntimeException("Идентификатор группы должен (gid = '" . $gid . "')быть >= 1");
        }

        $this->db->query('DELETE FROM `sys_access` WHERE `obj_id` = ' . $this->obj_id . ' AND `gid` = ' .  (int)$gid);
    }

    public function deleteUser($uid)
    {
        $uid = (int)$uid;

        if ($uid <= 0) {
            throw new mzzRuntimeException("Идентификатор пользователя должен (uid = '" . $uid . "')быть >= 1");
        }

        $this->db->query('DELETE FROM `sys_access` WHERE `obj_id` = ' . $this->obj_id . ' AND `uid` = ' .  (int)$uid);
    }

    public function getForGroup($gid)
    {
        if (empty($this->resultGroups[$this->obj_id])) {

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
        $toolkit = systemToolkit::getInstance();
        $userMapper = $toolkit->getMapper('user', 'user', 'user', $this->alias);

        $criteria = new criteria();
        $criteria->addJoin('sys_access', new criterion($userMapper->getTable() . '.' . $userMapper->getTableKey(), 'a.uid', criteria::EQUAL, true), 'a', criteria::JOIN_INNER);
        $criteria->addGroupBy($userMapper->getTable() . '.' . $userMapper->getTableKey());
        $criteria->add('a.obj_id', $this->obj_id);

        return $userMapper->searchAllByCriteria($criteria);
    }

    public function getUsersListDefault($section, $class)
    {
        $toolkit = systemToolkit::getInstance();
        $userMapper = $toolkit->getMapper('user', 'user', 'user', $this->alias);

        $criteria = new criteria();
        $criteria->addJoin('sys_access', new criterion('a.uid', $userMapper->getTable() . '.' . $userMapper->getTableKey(), criteria::EQUAL, true), 'a', criteria::JOIN_INNER);
        $criteria->addJoin('sys_access_classes_sections_actions', new criterion('csa.id', 'a.class_section_action', criteria::EQUAL, true), 'csa', criteria::JOIN_INNER);
        $criteria->addJoin('sys_access_classes_sections', new criterion('cs.id', 'csa.class_section_id', criteria::EQUAL, true), 'cs', criteria::JOIN_INNER);

        $criterion_class = new criterion('c.id', 'cs.class_id', criteria::EQUAL, true);
        $criterion_class->addAnd(new criterion('c.name', $class));
        $criteria->addJoin('sys_access_classes', $criterion_class, 'c', criteria::JOIN_INNER);

        $criterion_section = new criterion('s.id', 'cs.section_id', criteria::EQUAL, true);
        $criterion_section->addAnd(new criterion('s.name', $section));
        $criteria->addJoin('sys_access_sections', $criterion_section, 's', criteria::JOIN_INNER);

        $criteria->add('a.obj_id', 0);

        return $userMapper->searchAllByCriteria($criteria);
    }

    public function getGroupsList()
    {
        $toolkit = systemToolkit::getInstance();
        $groupMapper = $toolkit->getMapper('user', 'group', 'user', $this->alias);

        $criteria = new criteria();
        $criteria->addJoin('sys_access', new criterion($groupMapper->getTable() . '.' . $groupMapper->getTableKey(), 'a.gid', criteria::EQUAL, true), 'a', criteria::JOIN_INNER);
        $criteria->addGroupBy($groupMapper->getTable() . '.' . $groupMapper->getTableKey());
        $criteria->add('a.obj_id', $this->obj_id);

        return $groupMapper->searchAllByCriteria($criteria);
    }

    public function getGroupsListDefault($section, $class)
    {
        $toolkit = systemToolkit::getInstance();
        $groupMapper = $toolkit->getMapper('user', 'group', 'user', $this->alias);

        $criteria = new criteria();
        $criteria->addJoin('sys_access', new criterion('a.gid', $groupMapper->getTable() . '.' . $groupMapper->getTableKey(), criteria::EQUAL, true), 'a', criteria::JOIN_INNER);
        $criteria->addJoin('sys_access_classes_sections_actions', new criterion('csa.id', 'a.class_section_action', criteria::EQUAL, true), 'csa', criteria::JOIN_INNER);
        $criteria->addJoin('sys_access_classes_sections', new criterion('cs.id', 'csa.class_section_id', criteria::EQUAL, true), 'cs', criteria::JOIN_INNER);

        $criterion_class = new criterion('c.id', 'cs.class_id', criteria::EQUAL, true);
        $criterion_class->addAnd(new criterion('c.name', $class));
        $criteria->addJoin('sys_access_classes', $criterion_class, 'c', criteria::JOIN_INNER);

        $criterion_section = new criterion('s.id', 'cs.section_id', criteria::EQUAL, true);
        $criterion_section->addAnd(new criterion('s.name', $section));
        $criteria->addJoin('sys_access_sections', $criterion_section, 's', criteria::JOIN_INNER);

        $criteria->add('a.obj_id', 0);

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
        $qry = 'SELECT `a`.`name`, `a`.`id` FROM `sys_access_registry` `r`
                 INNER JOIN `sys_access_classes_sections` `cs` ON `cs`.`id` = `r`.`class_section_id`
                  INNER JOIN `sys_access_classes_sections_actions` `csa` ON `csa`.`class_section_id` = `cs`.`id`
                   INNER JOIN `sys_access_actions` `a` ON `a`.`id` = `csa`.`action_id`
                    WHERE `r`.`obj_id` = ' . $this->obj_id;
        $stmt = $this->db->query($qry);
        $validActions = $stmt->fetchAll();

        foreach ($validActions as $val) {
            $this->validActions[$this->obj_id][$val['name']] = $val['id'];
        }

        if (!isset($this->validActions[$this->obj_id]) || !sizeof($this->validActions[$this->obj_id])) {
            throw new mzzRuntimeException('Выбранный объект не зарегистрирован в acl');
        }

        if (!is_array($param)) {
            $param = array($param => $value);
        }

        $csa_ids = array();
        $inserts = '';

        foreach ($param as $key => $val) {
            if (!isset($this->validActions[$this->obj_id][$key])) {
                throw new mzzInvalidParameterException('У выбранного объекта нет изменяемого действия', $key);
            }

            $csa_ids[] = $this->validActions[$this->obj_id][$key];
            $inserts .= '(' . $this->validActions[$this->obj_id][$key] . ', ' . $this->obj_id . ', ' . ($group_id > 0 ? $group_id : $this->uid) . ', ' . (int)$val . '), ';
        }

        // удаляем старые действия
        if (sizeof($csa_ids)) {
            $qry = 'DELETE FROM `sys_access` WHERE `class_section_action` IN (' . implode(', ', $csa_ids) . ') AND `obj_id` = ' . $this->obj_id . ' AND ';
            $qry .= $group_id > 0 ? '`gid` = ' . $group_id : '`uid` = ' . $this->uid;
            $this->db->query($qry);
        }

        // добавляем новые
        $inserts = substr($inserts, 0, -2);
        if ($inserts) {
            $this->db->query('INSERT INTO `sys_access` (`class_section_action`, `obj_id`, `' . ($group_id > 0 ? 'gid' : 'uid') . '`, `allow`)
                                VALUES ' . $inserts);
        }

        // удаляем кэш
        unset($this->result[$this->obj_id]);
    }

    public function setForGroup($gid, $param)
    {
        return $this->set($param, null, (int)$gid);
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
     * @param string $section имя раздела
     */
    public function register($obj_id, $class = null, $section = null, $module = null)
    {
        $this->obj_id = (int)$obj_id;

        if ($this->obj_id <= 0) {
            throw new mzzInvalidParameterException('Свойство obj_id должно быть целочисленного типа и иметь значение > 0', $this->obj_id);
        }

        if (!empty($class)) {
            $this->class = $class;
        }

        if (!empty($section)) {
            $this->section = $section;
        }

        if (empty($this->class) || !is_string($this->class)) {
            throw new mzzInvalidParameterException('Свойство $class не установлено или имеет тип, отличный от string', $this->class);
        }

        if (empty($this->section) || !is_string($this->section)) {
            throw new mzzInvalidParameterException('Свойство $section не установлено или имеет тип, отличный от string', $this->section);
        }

        $qry = $this->getQuery();
        $this->doRoutine($qry, $obj_id);

        $id = $this->getClassSection($this->class, $this->section);

        $this->db->query('INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) VALUES (' . $this->obj_id . ', ' . $id . ')');
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

        $this->db->query('DELETE FROM `sys_access` WHERE `obj_id` = ' . (int)$obj_id);
        $this->db->query('DELETE FROM `sys_access_registry` WHERE `obj_id` = ' . (int)$obj_id);
    }

    public function getClass()
    {
        $qry = 'SELECT `c`.`name` FROM `sys_access_registry` `r`
                 INNER JOIN `sys_access_classes_sections` `cs` ON `cs`.`id` = `r`.`class_section_id`
                  INNER JOIN `sys_access_classes` `c` ON `c`.`id` = `cs`.`class_id`
                   WHERE `r`.`obj_id` = ' . $this->obj_id;
        return $this->db->getOne($qry);
    }

    public function getModule()
    {
        $qry = 'SELECT `m`.`name` FROM `sys_access_registry` `r`
                 INNER JOIN `sys_access_classes_sections` `cs` ON `cs`.`id` = `r`.`class_section_id`
                  INNER JOIN `sys_access_classes` `c` ON `c`.`id` = `cs`.`class_id`
                   INNER JOIN `sys_access_modules` `m` ON `m`.`id` = `c`.`module_id`
                    WHERE `r`.`obj_id` = ' . $this->obj_id;
        return $this->db->getOne($qry);
    }

    private function getClassSection($class, $section)
    {
        $qry = "SELECT `cs`.`id` FROM `sys_access_classes_sections` `cs`
                 INNER JOIN `sys_access_classes` `c` ON `c`.`id` = `cs`.`class_id`
                  INNER JOIN `sys_access_sections` `s` ON `s`.`id` = `cs`.`section_id`
                   WHERE `c`.`name` = " . $this->db->quote($class) . " AND `s`.`name` = " . $this->db->quote($section);
        $id = $this->db->getOne($qry);

        if (is_null($id)) {
            $section_id = $this->db->getOne('SELECT `id` FROM `sys_access_sections` WHERE `name` = ' . $this->db->quote($section));
            if (is_null($section_id)) {
                $this->db->query('INSERT INTO `sys_access_sections` (`name`) VALUES (' . $this->db->quote($section) . ')');
                $section_id = $this->db->lastInsertId();
            }

            $class_id = $this->db->getOne('SELECT `id` FROM `sys_access_classes` WHERE `name` = ' . $this->db->quote($class));

            if (is_null($class_id)) {
                throw new mzzRuntimeException('Класс <i>' . $class . '</i> не зарегистрирован в acl (в таблице sys_access_classes)');
            }

            $this->db->query('INSERT INTO `sys_access_classes_sections` (`class_id`, `section_id`) VALUES (' . $class_id . ', ' . $section_id . ')');
            $id = $this->db->lastInsertId();
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
        return 'SELECT `a`.* FROM `sys_access_classes_sections` `ms`
                 INNER JOIN `sys_access_classes` `m` ON `ms`.`class_id` = `m`.`id` AND `m`.`name` = :class
                  INNER JOIN `sys_access_sections` `s` ON `ms`.`section_id` = `s`.`id` AND `s`.`name` = :section
                   INNER JOIN `sys_access_classes_sections_actions` `msp` ON `msp`.`class_section_id` = `ms`.`id`
                    INNER JOIN `sys_access_actions` `p` ON `p`.`id` = `msp`.`action_id`
                     INNER JOIN `sys_access` `a` ON `a`.`class_section_action` = `p`.`id` AND `a`.`obj_id` = 0';
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

        $this->bind($stmt, $obj_id);

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
        $qry = 'INSERT INTO `sys_access` (`class_section_action`, `uid`, `gid`, `allow`, `obj_id`) VALUES ';

        $exists = false;
        while($row = $stmt->fetch()) {
            $qry .= "(" . $this->db->quote($row['class_section_action']) . ", "; // . $this->db->quote($row['type']) . ", ";
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
     * бинд всех переменных в стейтмент
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
                throw new mzzInvalidParameterException('Свойство obj_id должно быть целочисленного типа и иметь значение > 0', $this->obj_id);
            }
            $stmt->bindParam(':obj_id', $obj_id);
        } else {
            if ($this->obj_id <= 0) {
                throw new mzzInvalidParameterException('Свойство obj_id должно быть целочисленного типа и иметь значение > 0', $this->obj_id);
            }
            $stmt->bindParam(':obj_id', $this->obj_id);
        }
        $stmt->bindParam(':uid', $this->uid);
    }
}

?>