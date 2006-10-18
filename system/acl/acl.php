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
     * тип объекта
     *
     * @var string
     */
    //private $type;

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

    /**
     * массив для хранения валидных экшнов для конкретного объекта
     *
     * @var array
     */
    private $validActions = array();

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
        if (empty($user)) {
            $toolkit = systemToolkit::getInstance();
            $user = $toolkit->getUser($alias);
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
     * @return array|bool массив с правами | наличие/отсутствие права
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

            $qry = 'SELECT MIN(`a`.`allow`) AS `access`, `p`.`name` FROM `sys_access` `a`
                     INNER JOIN `sys_access_classes_sections_actions` `msp` ON `a`.`class_section_action` = `msp`.`id`
                      INNER JOIN `sys_access_actions` `p` ON `msp`.`action_id` = `p`.`id`
                       WHERE `a`.`obj_id` = :obj_id AND (`a`.`uid` = :uid';

            if (sizeof($this->groups)) {
                $qry .= ' OR `a`.`gid` IN (' . $grp . ')';
            }

            $qry .= ')';

            $qry .= ' GROUP BY `a`.`class_section_action`';

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

    public function getUsersList()
    {
        $this->initDb();

        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();
        $userMapper = $toolkit->getMapper('user', 'user', 'user');

        $qry = 'SELECT DISTINCT(`u`.`id`) FROM `sys_access` `a`
                 INNER JOIN `' . $userMapper->getTable() . '` `u` ON `u`.`' . $userMapper->getTableKey() . '` = `a`.`uid`
                  WHERE `a`.`obj_id` = ' . $this->obj_id;

        $stmt = $this->db->query($qry);
        $usersIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $result = array();
        foreach ($usersIds as $val) {
            $result[] = $userMapper->searchById($val);
        }

        return $result;
    }

    public function getGroupsList()
    {
        $this->initDb();

        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();
        $groupMapper = $toolkit->getMapper('user', 'group', 'user');

        $qry = 'SELECT DISTINCT(`g`.`id`) FROM `sys_access` `a`
                 INNER JOIN `' . $groupMapper->getTable() . '` `g` ON `g`.`' . $groupMapper->getTableKey() . '` = `a`.`gid`
                  WHERE `a`.`obj_id` = ' . $this->obj_id;

        $stmt = $this->db->query($qry);
        $groupsIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $result = array();
        foreach ($groupsIds as $val) {
            $result[] = $groupMapper->searchById($val);
        }

        return $result;
    }

    /**
     * Метод для установки прав<br>
     * устанавливать можно как свойства по одному, так и группу сразу
     *
     * @param string|array $param строка с именем изменяемого действия, или массив с ними же
     * @param boolean $value устанавливаемое значение
     */
    public function set($param, $value = null)
    {
        $this->initDb();

        // выбираем все корректные экшны для данного ДО
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
            $inserts .= '(' . $this->validActions[$this->obj_id][$key] . ', ' . $this->obj_id . ', ' . $this->uid . ', ' . (int)$val . '), ';
        }

        // удаляем старые действия
        if (sizeof($csa_ids)) {
            $this->db->query('DELETE FROM `sys_access` WHERE `class_section_action` IN (' . implode(', ', $csa_ids) . ') AND `obj_id` = ' . $this->obj_id . ' AND `uid` = ' . $this->uid);
        }

        // добавляем новые
        $inserts = substr($inserts, 0, -2);
        if ($inserts) {
            $this->db->query('INSERT INTO `sys_access` (`class_section_action`, `obj_id`, `uid`, `allow`)
                                VALUES ' . $inserts);
        }

        // удаляем кэш
        unset($this->result[$this->obj_id]);
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

        $this->initDb();

        $qry = $this->getQuery();
        $this->doRoutine($qry, $obj_id);
    }

    /**
     * метод удаления объекта из системы авторизации<br>
     * в случае, если аргумент $obj_id не указан, удаляется текущий объект
     *
     * @param integer $obj_id идентификатор удаляемого объекта
     */
    public function delete($obj_id = 0)
    {
        $this->initDb();

        $stmt = $this->db->prepare('DELETE FROM `sys_access` WHERE `obj_id` = :obj_id');

        $this->bind($stmt, $obj_id);

        $stmt->execute();
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
     * метод инициализации объекта работы с базой данных<br>
     * запускается при надобности
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
            $stmt->bindParam(':obj_id', $this->obj_id);
        }
        $stmt->bindParam(':uid', $this->uid);
    }
}

?>