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
 * @version $Id: objectIdGenerator.php 251 2006-11-01 04:49:40Z zerkms $
*/

/**
 * objectIdGenerator: ����� ��� ��������� ����������� id ��� DAO �������� �������
 *
 * @package system
 * @subpackage core
 * @version 0.1.2
 */

class objectIdGenerator
{
    /**
     * ������ ��� ������ � ��
     *
     * @var object
     */
    private $db;

    /**
     * ����� ������� � �������, ����� �������� ��������� � �������
     *
     * @var integer
     */
    private $clearEvery = 1000000;

    /**
     * �����������
     *
     */
    public function __construct()
    {
        $this->db = DB::factory();
    }

    /**
     * �����, ������������ ��������� �����
     *
     * @return integer
     */
    public function generate($name = null)
    {
        if (!is_null($name)) {
            $id = $this->db->getOne('SELECT `obj_id` FROM `sys_obj_id_named` WHERE `name` = ' . $this->db->quote($name));
            if (is_null($id)) {
                $id = $this->generate();
                $this->db->query('INSERT INTO `sys_obj_id_named` (`obj_id`, `name`) VALUES (' . $id .', ' . $this->db->quote($name) . ')');
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
     * �����, ���������� 1 ��� � $clearEvery �������
     *
     * @see objectIdGenerator::generate()
     * @param integer $id ������������� ��������� ����������� ������
     */
    private function clean($id)
    {
        $this->db->query('DELETE FROM `sys_obj_id`');
        $this->insert($id);
    }

    /**
     * ���������� ���������� id � �������
     *
     * @param integer $id ���������� �����, ������������ ���� ����� �������� ������ �� �� �������
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