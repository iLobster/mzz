<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/core/uidGenerator.php $
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
 * @version $Id: uidGenerator.php 888 2006-07-17 14:12:33Z zerkms $
*/

/**
 * objectIdGenerator: класс для генерации уникального id для DAO объектов системы
 *
 * @package system
 * @subpackage core
 * @version 0.1
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
        $this->insert();
        $id = $this->db->lastInsertId();
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
    }
}

?>