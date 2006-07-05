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
 * config: класс для работы с конфигурацией
 *
 * @package system
 * @version 0.4.1
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
    protected function getValues()
    {
        $this->db = db::factory();
        $stmt = $this->db->prepare("SELECT IFNULL(`val`.`name`, `val_def`.`name`) as `name`,
IFNULL(`val`.`value`, `val_def`.`value`) as `value` FROM `sys_cfg` `cfg_def`
INNER JOIN `sys_cfg_values` `val_def` ON `val_def`.`cfg_id` = `cfg_def`.`id` AND `cfg_def`.`section` = ''
LEFT JOIN `sys_cfg` `cfg` ON `cfg`.`section` = :section AND `cfg`.`module` = :module
LEFT JOIN `sys_cfg_values` `val` ON `val`.`cfg_id` = `cfg`.`id` AND `val`.`name` = `val_def`.`name`
WHERE `cfg_def`.`module` = :module");

        $stmt->bindParam(':section', $this->section);
        $stmt->bindParam(':module', $this->module);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_GROUP);
    }

    /**
     * Получает конкретное значение из конфигурации
     *
     * @param string $name имя значения
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
}

?>