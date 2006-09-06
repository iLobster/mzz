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
 * @version $Id: objectIdGenerator.php 1 2006-09-05 21:03:12Z zerkms $
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
    private $db;
    private $clearEvery = 1000000;

    public function __construct()
    {
        $this->db = DB::factory();
    }

    public function generate()
    {
        $id = $this->insert();
        if ($id % $this->clearEvery == 0) {
            $this->clean($id);
        }
        return $id;
    }

    private function clean($id)
    {
        $this->db->query('DELETE FROM `sys_obj_id`');
        $this->insert($id);
    }

    private function insert($id = 0)
    {
        $this->db->query('INSERT INTO `sys_obj_id` (`id`) VALUES (' . $id . ')');
        if ($id == 0) {
            return $this->db->lastInsertId();
        }
    }
}

?>