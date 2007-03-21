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
     * Секция, для которой будет получена конфигурация
     *
     * @var string
     * @see __construct()
     */
    protected $section;

    /**
     * Идентификатор конфигурации
     *
     * @var integer
     */
    protected $cfg_id = null;

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
     * @param string $section имя секции
     * @param string $module имя модуля
     */
    public function __construct($section, $module)
    {
        $this->section = $section;
        $this->module = $module;
    }

    /**
     * Запрос на получение всех значений конфигурации
     *
     * @return array
     */
    public function getValues()
    {
        $this->db = db::factory();
        $stmt = $this->db->prepare("SELECT `t`.`title`, `v`.`name`,
                                     IFNULL(`val`.`value`, `val_def`.`value`) as `value` FROM `sys_cfg` `cfg_def`
                                      INNER JOIN `sys_cfg_values` `val_def` ON `val_def`.`cfg_id` = `cfg_def`.`id` AND `cfg_def`.`section` = 0
                                       LEFT JOIN `sys_sections` `s` ON `s`.`name` = :section
                                        LEFT JOIN `sys_modules` `m` ON `m`.`name` = :module
                                         LEFT JOIN `sys_cfg` `cfg` ON `cfg`.`section` = `s`.`id` AND `cfg`.`module` = `m`.`id`
                                          LEFT JOIN `sys_cfg_values` `val` ON `val`.`cfg_id` = `cfg`.`id` AND `val`.`name` = `val_def`.`name`
                                           INNER JOIN `sys_cfg_vars` `v` ON `v`.`id` = `val_def`.`name`
                                            LEFT JOIN `sys_cfg_titles` `t` ON `t`.`id` = `val_def`.`title`
                                             WHERE `cfg_def`.`module` = `m`.`id`");

        $stmt->bindParam(':section', $this->section);
        $stmt->bindParam(':module', $this->module);
        $stmt->execute();

        $result = array();

        while ($row = $stmt->fetch()) {
            $result[$row['name']] = array('title' => $row['title'], 'value' => $row['value']);
            $this->titles[$row['name']] = $row['title'];
        }

        return $result;

        //return $stmt->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_GROUP);
    }

    /**
     * Получает конкретное значение для параметра из конфигурации
     *
     * @param string $name имя параметра
     * @return string|null
     * @see getValues()
     */
    public function get($name)
    {
        if (empty($this->values)) {
            $this->values = $this->getValues();
        }
        return isset($this->values[$name]['value']) ? $this->values[$name]['value'] : null;
    }

    /**
     * Устанавливает значение для параметра конфигурации
     *
     * @param string $name имя параметра
     * @param string|null $value значение
     * @see getCfgId()
     */
    public function set($name, $value = null)
    {
        if (empty($this->cfg_id)) {
            $this->getCfgId($this->section, $this->module);
        }

        if (!is_array($name)) {
            $name = array($name => $value);
        }

        $allowed_keys = array_keys($this->getDefaultValues());

        foreach (array_keys($name) as $key) {
            if (!in_array($key, $allowed_keys)) {
                unset($name[$key]);
            }
        }

        $namesAndTitles = $this->getNamesAndTitles();

        $data = '';
        foreach ($name as $key => $val) {
            $data .= '(' . $this->db->quote($val) . ', ' . $this->cfg_id . ', ' . $namesAndTitles[$key]['name'] . ', ' . $namesAndTitles[$key]['title'] . '), ';
        }
        $data = substr($data, 0, -2);

        if ($data) {
            $this->db->query('REPLACE INTO `sys_cfg_values` (`value`, `cfg_id`, `name`, `title`) VALUES ' . $data);
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
    private function getNamesAndTitles()
    {
        $this->db = db::factory();
        $stmt = $this->db->prepare("SELECT `vars`.`name`, `v`.`name` AS `name_id`, `v`.`title` AS `title_id` FROM `sys_modules` `m`
                                     INNER JOIN `sys_cfg` `c` ON `c`.`module` = `m`.`id` AND `section` = 0
                                      INNER JOIN `sys_cfg_values` `v` ON `v`.`cfg_id` = `c`.`id`
                                        INNER JOIN `sys_cfg_vars` `vars` ON `vars`.`id` = `v`.`name`
                                         WHERE `m`.`name` = :module");
        $stmt->bindParam(':module', $this->module);
        $stmt->execute();

        $result = array();
        while ($row = $stmt->fetch()) {
            $result[$row['name']] = array('name' => $row['name_id'], 'title' => $row['title_id']);
        }

        return $result;
    }

    /**
     * Получение значений параметров по-умолчанию
     *
     * @return array
     */
    public function getDefaultValues()
    {
        $this->db = db::factory();
        $stmt = $this->db->prepare("SELECT `vars`.`name`, `v`.`value`, `t`.`title` AS `title` FROM `sys_modules` `m`
                                     INNER JOIN `sys_cfg` `c` ON `c`.`module` = `m`.`id` AND `section` = 0
                                      INNER JOIN `sys_cfg_values` `v` ON `v`.`cfg_id` = `c`.`id`
                                       INNER JOIN `sys_cfg_vars` `vars` ON `vars`.`id` = `v`.`name`
                                        LEFT JOIN `sys_cfg_titles` `t` ON `t`.`id` = `v`.`title`
                                         WHERE `m`.`name` = :module");
        $stmt->bindParam(':module', $this->module);
        $stmt->execute();

        $result = array();
        while ($row = $stmt->fetch()) {
            $result[$row['name']] = $row['value'];
            $this->titles[$row['name']] = $row['title'];
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
    public function update($oldname, $name, $value = null, $title = null)
    {
        $old_name_id = $this->findVar($oldname);
        $cfg_id = $this->db->getOne('SELECT `s`.`id` FROM `sys_cfg` `s` INNER JOIN `sys_modules` `m` ON `m`.`id` = `s`.`module` WHERE `m`.`name` = ' . $this->db->quote($this->module) . ' AND `section` = 0');

        if ($name != $oldname) {
            $name_id = $this->findVar($name, true);

            $module_id = $this->findModule();

            $stmt = $this->db->query('SELECT `id` FROM `sys_cfg` WHERE `module` = ' . $module_id);
            $ids = '';
            while ($row = $stmt->fetch()) {
                $ids .= $row['id'] . ', ';
            }
            $ids = substr($ids, 0, -2);

            $this->db->query('UPDATE `sys_cfg_values` SET `name` = ' . $name_id . ' WHERE `cfg_id` IN (' . $ids . ') AND `name` = ' . $old_name_id);

            $old_name_id = $name_id;
        }

        if (!is_null($value)) {
            $this->db->query('UPDATE `sys_cfg_values` SET `value` = ' . $this->db->quote($value) . ' WHERE `cfg_id` = ' . $cfg_id . ' AND `name` = ' . $old_name_id);
        }

        if (!is_null($title)) {
            if ($title == '') {
                $title = $name;
            }

            $title_id = $this->findTitle($title, true);
            $this->db->query('UPDATE `sys_cfg_values` SET `title` = ' . $title_id . ' WHERE `cfg_id` = ' . $cfg_id . ' AND `name` = ' . $old_name_id);
        }
    }

    /**
     * Метод создания параметра
     *
     * @param string $name
     * @param string $value
     * @param string $title
     */
    public function create($name, $value, $title)
    {
        $this->db = db::factory();
        $cfg_id = $this->db->getOne('SELECT `s`.`id` FROM `sys_cfg` `s` INNER JOIN `sys_modules` `m` ON `m`.`id` = `s`.`module` WHERE `m`.`name` = ' . $this->db->quote($this->module) . ' AND `section` = 0');

        $name = $this->findVar($name, true);
        $title = $this->findTitle($title, true);

        $this->db->query('INSERT INTO `sys_cfg_values` (`cfg_id`, `name`, `value`, `title`) VALUES (' . $cfg_id . ', ' . $name . ', ' . $this->db->quote($value) . ', ' . $title . ')');
    }

    /**
     * Метод удаления параметра
     *
     * @param string $name
     */
    public function delete($name)
    {
        $module_id = $this->findModule();
        $stmt = $this->db->query('SELECT `id` FROM `sys_cfg` WHERE `module` = ' . $module_id);
        $ids = '';
        while ($row = $stmt->fetch()) {
            $ids .= $row['id'] . ', ';
        }
        $ids = substr($ids, 0, -2);

        $name = $this->findVar($name);

        if ($name) {
            $this->db->query($qry = 'DELETE FROM `sys_cfg_values` WHERE `cfg_id` IN (' . $ids . ') AND `name` = ' . $name);
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
        return $this->db->getOne('SELECT `id` FROM `sys_modules` WHERE `name` = ' . $this->db->quote($this->module));
    }

    /**
     * Получает идентификатор конфигурации по секции и модулю
     *
     * @param string $section секция
     * @param string $module модуль
     */
    private function getCfgId($section, $module)
    {
        $this->db = db::factory();

        $stmt = $this->db->prepare('SELECT `sys_cfg`.`id` FROM `sys_cfg`
                                     LEFT JOIN `sys_sections` `s` ON `s`.`name` = :section
                                      LEFT JOIN `sys_modules` `m` ON `m`.`name` = :module
                                       WHERE `sys_cfg`.`section` = `s`.`id` AND `sys_cfg`.`module` = `m`.`id`');
        $stmt->bindParam(':section', $section);
        $stmt->bindParam(':module', $module);
        $stmt->execute();
        $result = $stmt->fetch();

        if (isset($result['id'])) {
            $this->cfg_id = (int)$result['id'];
        } else {
            $module_id = $this->db->getOne('SELECT `id` FROM `sys_modules` WHERE `name` = ' . $this->db->quote($module));
            $section_id = $this->db->getOne('SELECT `id` FROM `sys_sections` WHERE `name` = ' . $this->db->quote($section));

            if ($module_id && $section_id) {
                $this->db->query('INSERT INTO `sys_cfg` (`section`, `module`) VALUES (' . $section_id . ', ' . $module_id . ')');
                $this->getCfgId($section, $module);
            } else {
                throw new mzzRuntimeException('Config for section: ' . $section . ', module: ' . $module . ' not found.');
            }
        }
    }
}

?>
