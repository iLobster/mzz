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
 * @version 0.5.1
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
        $stmt = $this->db->prepare("SELECT IFNULL(`val`.`name`, `val_def`.`name`) as `name`,
                                     IFNULL(`val`.`value`, `val_def`.`value`) as `value` FROM `sys_cfg` `cfg_def`
                                      INNER JOIN `sys_cfg_values` `val_def` ON `val_def`.`cfg_id` = `cfg_def`.`id` AND `cfg_def`.`section` = 0
                                       LEFT JOIN `sys_sections` `s` ON `s`.`name` = :section
                                        LEFT JOIN `sys_modules` `m` ON `m`.`name` = :module
                                         LEFT JOIN `sys_cfg` `cfg` ON `cfg`.`section` = `s`.`id` AND `cfg`.`module` = `m`.`id`
                                          LEFT JOIN `sys_cfg_values` `val` ON `val`.`cfg_id` = `cfg`.`id` AND `val`.`name` = `val_def`.`name`
                                           WHERE `cfg_def`.`module` = `s`.`id`");

        $stmt->bindParam(':section', $this->section);
        $stmt->bindParam(':module', $this->module);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_GROUP);
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
        return isset($this->values[$name][0]['value']) ? $this->values[$name][0]['value'] : null;
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

        $data = '';
        foreach ($name as $key => $val) {
            $data .= '(' . $this->db->quote($val) . ', ' . $this->cfg_id . ', ' . $this->db->quote($key) . '), ';
        }
        $data = substr($data, 0, -2);

        if ($data) {
            $this->db->query('REPLACE INTO `sys_cfg_values` (`value`, `cfg_id`, `name`) VALUES ' . $data);
            $this->values = null;
        }
    }

    public function getDefaultValues()
    {
        $this->db = db::factory();
        $stmt = $this->db->prepare("SELECT `v`.`name`, `v`.`value` FROM `sys_modules` `m`
                                    INNER JOIN `sys_cfg` `c` ON `c`.`module` = `m`.`id` AND `section` = 0
                                     INNER JOIN `sys_cfg_values` `v` ON `v`.`cfg_id` = `c`.`id`
                                      WHERE `m`.`name` = :module");
        $stmt->bindParam(':module', $this->module);
        $stmt->execute();

        $result = array();
        while ($row = $stmt->fetch()) {
            $result[$row['name']] = $row['value'];
        }

        return $result;
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
            throw new mzzRuntimeException('Config for section: ' . $section . ', module: ' . $module . ' not found.');
        }
    }
}

?>