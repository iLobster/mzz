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
 * @version $Id: objectIdGenerator.php 726 2007-03-19 01:21:20Z zerkms $
*/

/**
 * objectIdGenerator: класс для генерации уникального id для DAO объектов системы
 *
 * @package system
 * @subpackage core
 * @version 0.1.3
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
     * @var integer
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
     * @param string $name
     * @param boolean $generateNew
     * @return integer
     */
    public function generate($name = null, $generateNew = true)
    {
        $toolkit = systemToolkit::getInstance();
        $cache = $toolkit->getCache();

        if (!is_null($name)) {
            if (is_null($id = $cache->load($identifier = 'obj_id_' . $name))) {
                $id = $this->db->getOne('SELECT `obj_id` FROM `sys_obj_id_named` WHERE `name` = ' . $this->db->quote($name));

                if (is_null($id) && $generateNew) {
                    $id = $this->generate();
                    $this->db->query('INSERT INTO `sys_obj_id_named` (`obj_id`, `name`) VALUES (' . $id .', ' . $this->db->quote($name) . ')');
                } elseif (is_null($id)) {
                    $id = $this->generate('access_admin_admin', false);
                }

                $cache->save($identifier, $id);
            }

            return (int)$id;
        }

        $id = $this->insert();
        if ($id % $this->clearEvery == 0) {
            $this->clean($id);
        }
        return (int)$id;
    }

    /**
     * Метод, вызываемый 1 раз в $clearEvery записей
     *
     * @see objectIdGenerator::generate()
     * @param integer $id идентификатор последней добавленной записи
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