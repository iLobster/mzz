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
 * config: класс для работы с конфигурацией
 *
 * @package system
 * @version 0.5.5
 */

class config
{
    /**
     * Идентификатор модуля
     *
     * @var integer
     */
    protected $module_id = null;

    /**
     * Модуль, для которого будет получена конфигурация
     *
     * @var string
     * @see __construct()
     */
    protected $module;

    /**
     * Значения конфигурации для заданной секции и модуля
     *
     * @var array
     */
    protected $values = array();

    /**
     * Массив обозначений параметров
     *
     * @var array
     */
    protected $titles = array();

    /**
     * Ссылка на объект БД
     *
     * @var object
     */
    protected $db;

    /**
     * Конструктор
     *
     * @param string $module имя модуля
     */
    public function __construct($module)
    {
        $this->module = $module;
        $this->db = db::factory();
    }

    /**
     * Запрос на получение всех значений конфигурации
     *
     * @return array
     */
    public function getValues()
    {
        $stmt = $this->db->prepare("SELECT `t`.`title`, `v`.`name`, `ts`.`id` AS `type_id`, `ts`.`name` AS `type`, `ts`.`title` AS `typetitle`, `val`.`value`
                                     FROM `sys_modules` `m`
                                      LEFT JOIN `sys_cfg_values` `val` ON `val`.`module_id` = `m`.`id`
                                       INNER JOIN `sys_cfg_vars` `v` ON `v`.`id` = `val`.`name`
                                        LEFT JOIN `sys_cfg_titles` `t` ON `t`.`id` = `val`.`title`
                                         LEFT JOIN `sys_cfg_types` `ts` ON `ts`.`id` = `val`.`type_id`
                                              WHERE `m`.`name` = :module");

        $stmt->bindParam(':module', $this->module);
        $stmt->execute();

        $result = array();

        while ($row = $stmt->fetch()) {
            $result[$row['name']] = array('title' => $row['title'], 'value' => $row['value'], 'type' => array('id' => $row['type_id'], 'name' => $row['type'], 'title' => $row['typetitle']));
            $this->titles[$row['name']] = $row['title'];
        }

        return $result;

        //return $stmt->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_GROUP);
    }

    /**
     * Получает конкретное значение для параметра из конфигурации
     *
     * @param string $name имя параметра
     * @param mixed  $default_value значение по умолчанию
     * @return string|null
     * @see getValues()
     */
    public function get($name, $default_value = null)
    {
        if (empty($this->values)) {
            $this->values = $this->getValues();
        }

        return isset($this->values[$name]['value']) ? $this->values[$name]['value'] : $default_value;
    }

    /**
     * Устанавливает значение для параметра конфигурации
     *
     * @param string $name имя параметра
     * @param string|null $value значение
     */
    public function set($name, $value = null)
    {
        if (empty($this->module_id)) {
            $this->findModule();
        }

        if (!is_array($name)) {
            $name = array($name => $value);
        }

        $allowed_keys = array_keys($this->getValues());

        foreach (array_keys($name) as $key) {
            if (!in_array($key, $allowed_keys)) {
                unset($name[$key]);
            }
        }

        $vars = $this->getNamesAndTitlesAndTypes();

        $data = '';
        foreach ($name as $key => $val) {
            $data .= '(' . $this->db->quote($val) . ', ' . $this->module_id . ', ' . $vars[$key]['name'] . ', ' . $vars[$key]['title'] . ', ' . $vars[$key]['type'] . '), ';
        }
        $data = substr($data, 0, -2);

        if ($data) {
            $this->db->query('REPLACE INTO `sys_cfg_values` (`value`, `module_id`, `name`, `title`, `type_id`) VALUES ' . $data);
            $this->values = null;
        }
    }

    /**
     * Получение обозначения параметра по имени
     *
     * @param string $name
     * @return string
     */
    public function getTitle($name)
    {
        return $this->titles[$name];
    }

    /**
     * Получение имён и обозначений для всех параметров выбранного модуля
     *
     * @return array
     */
    private function getNamesAndTitlesAndTypes()
    {
        $stmt = $this->db->prepare("SELECT `vars`.`name`, `v`.`name` AS `name_id`, `v`.`title` AS `title_id`, `v`.`type_id` as `type_id`
                                     FROM `sys_modules` `m`
                                       INNER JOIN `sys_cfg_values` `v` ON `v`.`module_id` = `m`.`id`
                                        INNER JOIN `sys_cfg_vars` `vars` ON `vars`.`id` = `v`.`name`
                                         WHERE `m`.`name` = :module");
        $stmt->bindParam(':module', $this->module);
        $stmt->execute();

        $result = array();
        while ($row = $stmt->fetch()) {
            $result[$row['name']] = array('name' => $row['name_id'], 'title' => $row['title_id'], 'type' => $row['type_id']);
        }

        return $result;
    }

    /**
     * Метод обновления параметра
     *
     * @param string $oldname старое имя
     * @param string $name новое имя
     * @param string $value новое значение
     * @param string $title новое обозначение
     */
    public function update($oldname, $name, $value = null, $title = null, $type = null)
    {
        $old_name_id = $this->findVar($oldname);
        $this->findModule();

        if ($name != $oldname) {
            $name_id = $this->findVar($name, true);

            $this->db->query('UPDATE `sys_cfg_values` SET `name` = ' . $name_id . ' WHERE `module_id` = ' . $this->module_id . ' AND `name` = ' . $old_name_id);

            $old_name_id = $name_id;
        }

        if (!is_null($value)) {
            $this->db->query('UPDATE `sys_cfg_values` SET `value` = ' . $this->db->quote($value) . ' WHERE `module_id` = ' . $this->module_id . ' AND `name` = ' . $old_name_id);
        }

        if (!is_null($type)) {
            $this->db->query('UPDATE `sys_cfg_values` SET `type_id` = ' . $this->db->quote($type) . ' WHERE `module_id` = ' . $this->module_id . ' AND `name` = ' . $old_name_id);
        }

        if (!is_null($title)) {
            if ($title == '') {
                $title = $name;
            }

            $title_id = $this->findTitle($title, true);
            $this->db->query('UPDATE `sys_cfg_values` SET `title` = ' . $title_id . ' WHERE `module_id` = ' . $this->module_id . ' AND `name` = ' . $old_name_id);
        }
    }

    /**
     * Метод создания параметра
     *
     * @param string $name
     * @param string $value
     * @param string $title
     */
    public function create($name, $value, $title, $type)
    {
        $this->findModule();

        $name = $this->findVar($name, true);
        $title = $this->findTitle($title, true);

        $this->db->query('INSERT INTO `sys_cfg_values` (`module_id`, `name`, `value`, `title`, `type_id`) VALUES (' . $this->module_id . ', ' . $name . ', ' . $this->db->quote($value) . ', ' . $title . ', ' . $type . ')');
    }

    /**
     * Метод удаления параметра
     *
     * @param string $name
     */
    public function delete($name)
    {
        $this->findModule();

        $name = $this->findVar($name);

        if ($name) {
            $this->db->query($qry = 'DELETE FROM `sys_cfg_values` WHERE `module_id` = ' . $this->module_id . ' AND `name` = ' . $name);
        }
    }

    /**
     * Метод поиска ид параметра по его имени
     *
     * @param string $name имя параметра
     * @param booleab $create в случае отсутствия параметра - создавать новый или нет
     * @return integer
     */
    private function findVar($name, $create = false)
    {
        $var_id = $this->db->getOne('SELECT `id` FROM `sys_cfg_vars` WHERE `name` = ' . $this->db->quote($name));

        if ($create && is_null($var_id)) {
            $this->db->query('INSERT INTO `sys_cfg_vars` (`name`) VALUES (' . $this->db->quote($name) . ')');
            return $this->db->lastInsertId();
        }

        return $var_id;
    }

    /**
     * Метод поиска ид обозначения по его имени
     *
     * @param string $title обозначение параметра
     * @param booleab $create в случае отсутствия обозначения - создавать новый или нет
     * @return integer
     */
    private function findTitle($title, $create = false)
    {
        $title_id = $this->db->getOne('SELECT `id` FROM `sys_cfg_titles` WHERE `title` = ' . $this->db->quote($title));

        if ($create && is_null($title_id)) {
            $this->db->query('INSERT INTO `sys_cfg_titles` (`title`) VALUES (' . $this->db->quote($title) . ')');
            return $this->db->lastInsertId();
        }

        return $title_id;
    }

    /**
     * Поиск ид текущего модуля
     *
     * @return integer
     */
    private function findModule()
    {
        if (empty($this->module_id)) {
            $this->module_id = $this->db->getOne('SELECT `id` FROM `sys_modules` WHERE `name` = ' . $this->db->quote($this->module));
        }

        return $this->module_id;
    }

    /**
     * Получает список всех типов
     *
     * @return array
     */
    public function getTypes()
    {
        $stmt = $this->db->prepare('SELECT * FROM `sys_cfg_types`');
        $stmt->execute();

        return $stmt->fetchAll();
    }
}

?>
