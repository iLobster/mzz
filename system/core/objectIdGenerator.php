<?php
/**
 * $URL: http://svn.web/repository/mzz/system/core/objectIdGenerator.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage core
 * @version $Id: objectIdGenerator.php 76 2006-09-20 04:13:16Z zerkms $
*/

/**
 * objectIdGenerator: класс для генерации уникального id для DAO объектов системы
 *
 * @package system
 * @subpackage core
 * @version 0.1.2
 */

class objectIdGenerator
{
    /**
     * Объект для работы с БД
     *
     * @var object
     */
    private $db;

    /**
     * Число записей в таблице, после которого произойдёт её очистка
     *
     * @var unknown_type
     */
    private $clearEvery = 1000000;

    /**
     * Конструктор
     *
     */
    public function __construct()
    {
        $this->db = DB::factory();
    }

    /**
     * Метод, возвращающий следующий номер
     *
     * @return integer
     */
    public function generate()
    {
        $id = $this->insert();
        if ($id % $this->clearEvery == 0) {
            $this->clean($id);
        }
        return $id;
    }

    /**
     * Метод, вызываемый 1 раз в $clearEvery записей
     *
     * @see objectIdGenerator::generate()
     * @param integer $id id последней добавленной записи
     */
    private function clean($id)
    {
        $this->db->query('DELETE FROM `sys_obj_id`');
        $this->insert($id);
    }

    /**
     * Добавление очередного id в таблицу
     *
     * @param integer $id конкретный номер, используется если нужно добавить запись не по порядку
     * @return integer
     */
    private function insert($id = 0)
    {
        $this->db->query('INSERT INTO `sys_obj_id` (`id`) VALUES (' . $id . ')');
        if ($id == 0) {
            return $this->db->lastInsertId();
        }
    }
}

?>