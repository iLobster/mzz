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
     * @var unknown_type
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
    public function generate()
    {
        $id = $this->insert();
        if ($id % $this->clearEvery == 0) {
            $this->clean($id);
        }
        return $id;
    }

    /**
     * �����, ���������� 1 ��� � $clearEvery �������
     *
     * @see objectIdGenerator::generate()
     * @param integer $id id ��������� ����������� ������
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