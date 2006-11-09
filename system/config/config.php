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
 * config: ����� ��� ������ � �������������
 *
 * @package system
 * @version 0.4.1
*/
class config
{
    /**
     * ������, ��� ������� ����� �������� ������������
     *
     * @var string
     * @see __construct()
     */
    protected $section;

    protected $cfg_id;

    /**
     * ������, ��� �������� ����� �������� ������������
     *
     * @var string
     * @see __construct()
     */
    protected $module;

    /**
     * �������� ������������ ��� �������� ������ � ������
     *
     * @var array
     */
    protected $values = array();

    /**
     * ������ �� ������ ��
     *
     * @var object
     */
    protected $db;

    /**
     * �����������
     *
     * @param string $section ��� ������
     * @param string $module ��� ������
     */
    public function __construct($section, $module)
    {
        $this->section = $section;
        $this->module = $module;
    }

    /**
     * ������ �� ��������� ���� �������� ������������
     *
     * @return array
     */
    public function getValues()
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
     * �������� ���������� �������� �� ������������
     *
     * @param string $name ��� ��������
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
            $data .= '(' . $this->db->quote($val) .', ' . $this->cfg_id . ', ' . $this->db->quote($key) . '), ';
        }
        $data = substr($data, 0, -2);

        if ($data) {
            $this->db->query('REPLACE INTO `sys_cfg_values` (`value`, `cfg_id`, `name`) VALUES ' . $data);
            $this->values = null;
        }
    }

    private function getCfgId($section, $module)
    {
        $this->db = db::factory();

        $stmt = $this->db->prepare("SELECT `id` FROM `sys_cfg` WHERE `section` = :section AND `module` = :module");
        $stmt->bindParam(':section', $section);
        $stmt->bindParam(':module', $module);
        $stmt->execute();
        $result = $stmt->fetch();

        if (isset($result['id'])) {
            $this->cfg_id = $result['id'];
        } else {
            $stmt = $this->db->prepare("INSERT INTO `sys_cfg` (`section`, `module`) VALUES (:section, :module)");
            $stmt->bindParam(':section', $section);
            $stmt->bindParam(':module', $module);
            $this->cfg_id = $stmt->execute();
        }
    }
}

?>