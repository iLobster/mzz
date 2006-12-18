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
 * @version $Id$
*/

/**
 * adminMapper: маппер
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

fileLoader::load('admin');

class adminMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'admin';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'admin';

    public function getInfo()
    {
        $toolkit = systemToolkit::getInstance();
        $user = $toolkit->getUser();

        $info = $this->db->getAll("SELECT `m`.`name` AS `module`, `ss`.`name` AS `section`, `c`.`name` AS `class` FROM `sys_modules` `m`
                                    LEFT JOIN `sys_classes` `c` ON `c`.`module_id` = `m`.`id`
                                     LEFT JOIN `sys_classes_sections` `s` ON `s`.`class_id` = `c`.`id`
                                      LEFT JOIN `sys_sections` `ss` ON `ss`.`id` = `s`.`section_id`
                                       ORDER BY `m`.`name`, `ss`.`name`, `c`.`name`");
        $result = array();
        $access = array();
        $admin = array();

        $toolkit = systemToolkit::getInstance();

        foreach ($info as $val) {
            $obj_id = $toolkit->getObjectId('access_' . $val['section'] . '_' . $val['class']);
            $this->register($obj_id, 'sys', 'access');
            $acl = new acl($user, $obj_id);

            if (!isset($access[$val['section'] . '_' . $val['class']])) {
                $access[$val['section'] . '_' . $val['class']] = $acl->get('editACL');
                
                $action = $toolkit->getAction($val['module']);
                $actions = $action->getActions();
                $actions = $actions[$val['module']];
                
                $admin[$val['section'] . '_' . $val['class']] = isset($actions['admin']) && $acl->get('admin');
            }

            $result[$val['module']][$val['section']][] = array('class' => $val['class'], 'obj_id' => $obj_id, 'editACL' => $acl->get('editACL'), 'editDefault' => $acl->get('editDefault'));
        }

        return array('data' => $result, 'cfgAccess' => $access, 'admin' => $admin);
    }

    /**
     * Возвращает уникальный для ДО идентификатор исходя из аргументов запроса
     *
     * @return object
     */
    public function convertArgsToId($args)
    {
        $toolkit = systemToolkit::getInstance();
        $obj_id = $toolkit->getObjectId('access_admin_admin');
        $this->register($obj_id);
        return $obj_id;
    }
}

?>