<?php
/**
 * $URL$
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
 * @version $Id$
*/

/**
 * UIDGenerator: класс для генерации уникального id для объектов системы
 *
 * @package system
 * @subpackage core
 * @version 0.1
 */

class UIDGenerator
{
    private $db;
    private $clearEvery = 1000000;

    public function __construct()
    {
        $this->db = DB::factory();
    }

    public function generate()
    {
        $this->db->query('INSERT INTO `sys_uid` (`id`) VALUES (0)');
        $id = $this->db->lastInsertId();
        if ($id % $this->clearEvery == 0) {
            $this->clean($id);
        }
        return $id;
    }

    private function clean($id)
    {
        $this->db->query('DELETE FROM `sys_uid`');
        $this->db->query('INSERT INTO `sys_uid` (`id`) VALUES (' . $id . ')');
    }
}

?>