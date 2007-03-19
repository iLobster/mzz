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
 * @version 0.1.6
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

    /**
     * Метод получения общей инормации об установленных модулях, разделах и их отношений
     *
     * @return array
     */
    public function getInfo()
    {
        $toolkit = systemToolkit::getInstance();
        $user = $toolkit->getUser();

        $info = $this->db->getAll("SELECT `m`.`name` AS `module`, `ss`.`name` AS `section`, `c`.`name` AS `class`, `c2`.`name` AS `main_class` FROM `sys_modules` `m`
                                    LEFT JOIN `sys_classes` `c` ON `c`.`module_id` = `m`.`id`
                                     LEFT JOIN `sys_classes_sections` `s` ON `s`.`class_id` = `c`.`id`
                                      LEFT JOIN `sys_sections` `ss` ON `ss`.`id` = `s`.`section_id`
                                       LEFT JOIN `sys_classes` `c2` ON `c2`.`id` = `m`.`main_class`
                                        ORDER BY `m`.`name`, `ss`.`name`, `c`.`name`");
        $result = array();
        $access = array();
        $admin = array();
        $main = array();

        $toolkit = systemToolkit::getInstance();

        foreach ($info as $val) {
            $class = (!empty($val['main_class'])) ? $val['main_class'] : $val['class'];

            $obj_id = $toolkit->getObjectId('access_' . $val['section'] . '_' . $class);
            $this->register($obj_id, 'sys', 'access');
            $acl = new acl($user, $obj_id);

            $main[$val['module']] = $class;

            if (isset($val['section']) && isset($val['class'])) {
                //if (!isset($access[$val['section'] . '_' . $val['class']])) {
                $access[$val['section'] . '_' . $val['module']] = $acl->get('editACL');

                $action = $toolkit->getAction($val['module']);
                $actions = $action->getActions();
                $actions = $actions[$val['class']];

                $admin[$val['section'] . '_' . $val['class']] = isset($actions['admin']) && $acl->get('admin');
                //}

                $result[$val['module']][$val['section']][] = array('class' => $val['class'], 'obj_id' => $obj_id, 'editACL' => $acl->get('editACL'), 'editDefault' => $acl->get('editDefault'));
            }
        }

        return array('data' => $result, 'cfgAccess' => $access, 'admin' => $admin, 'main_class' => $main);
    }

    /**
     * Метод получения общей инормации об установленных модулях, разделах имеющих свои админки
     *
     * @return array
     */
    public function getAdminInfo()
    {
        $toolkit = systemToolkit::getInstance();
        $user = $toolkit->getUser();

        $info = $this->db->getAll("SELECT `m`.`name` AS `module`, `ss`.`name` AS `section`, `ss`.`title` AS `section_title`,
                                   `c`.`name` AS `main_class`, `m`.`title` as `module_title`, `m`.`icon` as `module_icon`,
                                    `m`.`order` as `module_order` FROM `sys_modules` `m`
                                     LEFT JOIN `sys_classes` `c` ON `c`.`id` = `m`.`main_class`
                                      LEFT JOIN `sys_classes_sections` `s` ON `s`.`class_id` = `c`.`id`
                                       LEFT JOIN `sys_sections` `ss` ON `ss`.`id` = `s`.`section_id`
                                        ORDER BY `m`.`order`, `ss`.`order`, `m`.`name`, `ss`.`name`");
        $result = array();

        $toolkit = systemToolkit::getInstance();

        foreach ($info as $val) {
            $class = $val['main_class'];

            $obj_id = $toolkit->getObjectId('access_' . $val['section'] . '_' . $class);

            $this->register($obj_id, 'sys', 'access');
            $acl = new acl($user, $obj_id);

            if (isset($val['section'])) {
                $action = $toolkit->getAction($val['module']);
                $actions = $action->getActions();
                $actions = $actions[$class];

                if (isset($actions['admin']) && $acl->get('admin')) {
                    if (!isset($result[$val['module']])) {
                        $result[$val['module']] = array('title' => $val['module_title'], 'icon' => $val['module_icon'], 'order' => $val['module_order'], 'sections' => array());
                    }
                    $result[$val['module']]['sections'][$val['section']] = array('title' => $val['section_title']);
                }
            }
        }

        return $result;
    }

    /**
     * Метод возвращает главный класс модуля
     *
     * @param string $module имя модуля
     * @return string
     */
    public function getMainClass($module)
    {
        $class = $this->db->getOne("SELECT `c`.`name` AS `main_class` FROM `sys_modules` `m`
                                     LEFT JOIN `sys_classes` `c` ON `c`.`id` = `m`.`main_class`
                                      WHERE `m`.`name` = " . $this->db->quote($module));
        return $class;
    }

    /**
     * Метод получения списка модулей и классов, которые им принадлежат
     *
     * @return array
     */
    public function getModulesList()
    {
        $modules = $this->db->getAll('SELECT (COUNT(`ca`.`id`) + COUNT(`cs`.`id`) > 0) AS `exists`, `m`.`name` AS `module`, `c`.`name` AS `class`, `c2`.`name` AS `main_class_name`, `m`.`id` AS `m_id`, `c`.`id` AS `c_id`, `m`.`main_class` FROM `sys_modules` `m`
                                         LEFT JOIN `sys_classes` `c` ON `c`.`module_id` = `m`.`id`
                                          LEFT JOIN `sys_classes` `c2` ON `c2`.`id` = `m`.`main_class`
                                           LEFT JOIN `sys_classes_actions` `ca` ON `ca`.`class_id` = `c`.`id`
                                            LEFT JOIN `sys_classes_sections` `cs` ON `cs`.`class_id` = `c`.`id`
                                             GROUP BY `m`.`name`, `c`.`name`');

        $result = array();

        foreach ($modules as $val) {
            if (!isset($result[$val['m_id']])) {
                if (empty($val['main_class_name'])) {
                    $val['main_class_name'] = $val['module'];
                }
                $result[$val['m_id']] = array('name' => $val['module'], 'main_class' => $val['main_class'], 'classes' => array(), 'main_class_name' => $val['main_class_name']);
            }

            if (!is_null($val['class'])) {
                if (!$val['exists']) {
                    $action = new action($val['module']);
                    $actions = $action->getActions();
                    if (isset($actions[$val['class']]) && sizeof($actions[$val['class']]) > 1) {
                        $val['exists'] = 1;
                    }
                }

                $result[$val['m_id']]['classes'][$val['c_id']] = array('name' => $val['class'], 'exists' => $val['exists']);
            }
        }

        return $result;
    }

    /**
     * Метод получения списка разделов и классов, принадлежащих им
     *
     * @return array
     */
    public function getSectionsList()
    {
        $sections = $this->db->getAll('SELECT DISTINCT `s`.`name` AS `section`, `s`.`id` AS `s_id`, `c`.`name` AS `class`, `c`.`id` AS `c_id` FROM `sys_sections` `s`
                                         LEFT JOIN `sys_classes_sections` `cs` ON `cs`.`section_id` = `s`.`id`
                                          LEFT JOIN `sys_classes` `c` ON `c`.`id` = `cs`.`class_id`
                                           ORDER BY `s`.`name`, `c`.`name`');

        $result = array();

        foreach ($sections as $val) {
            if (!isset($result[$val['s_id']])) {
                $result[$val['s_id']] = array('name' => $val['section'], 'classes' => array());
            }

            if (!is_null($val['class'])) {
                $result[$val['s_id']]['classes'][$val['c_id']] = $val['class'];
            }
        }

        return $result;
    }
    /*
    public function getAccessRegistry()
    {
    $result = $this->db->getAll('SELECT `r`.`obj_id`, `r`.`class_section_id`, `c`.`name` as `class`, `s`.`name` as `section`, `m`.`name` as `module` FROM `sys_access_registry` `r`
    LEFT JOIN `sys_classes_sections` `cs` ON `cs`.`id` = `r`.`class_section_id`
    LEFT JOIN `sys_classes` `c` ON `c`.`id` = `cs`.`class_id`
    LEFT JOIN `sys_modules` `m` ON `m`.`id` = `c`.`module_id`
    LEFT JOIN `sys_sections` `s` ON `s`.`id` = `cs`.`section_id`
    ORDER BY `c`.`name`, `s`.`name`, `r`.`obj_id`');
    return $result;
    }*/

    /**
     * Enter description here...
     *
     * @return unknown
     */
    public function getClassesInSections()
    {
        $classes = $this->db->getAll("SELECT `cs`.`id`, `c`.`name` as `class_name`, `s`.`name` as `section_name` FROM `sys_classes_sections` `cs`
                                               LEFT JOIN `sys_classes` `c` ON `c`.`id` = `cs`.`class_id`
                                                LEFT JOIN `sys_sections` `s` ON `s`.`id` = `cs`.`section_id`
                                                 ORDER BY `c`.`name`, `s`.`name`", PDO::FETCH_ASSOC);
        $result = array();
        foreach ($classes as $class) {
            $result[$class['section_name']][] = array('id' => $class['id'], 'class' => $class['class_name']);
        }
        return $result;
    }

    /**
     * Enter description here...
     *
     * @return unknown
     */
    public function getLatestRegisteredObj($items = 5)
    {
        $objects = $this->db->getAll("SELECT `ar`.`obj_id`, `c`.`name` as `class_name`, `s`.`name` as `section_name` FROM `sys_access_registry` `ar`
                                       LEFT JOIN `sys_classes_sections` `cs` ON `ar`.`class_section_id` = `cs`.`id`
                                        LEFT JOIN `sys_classes` `c` ON `c`.`id` = `cs`.`class_id`
                                         LEFT JOIN `sys_sections` `s` ON `s`.`id` = `cs`.`section_id`
                                          ORDER BY `ar`.`obj_id` DESC LIMIT 0, " . (int)$items, PDO::FETCH_ASSOC);
        return $objects;
    }

    public function getDests($onlyWritable = false, $subfolder = '')
    {
        if ($onlyWritable) {
            $dest = $this->getDests(false, $subfolder);

            foreach ($dest as $key => $val) {
                if (!is_writable($val)) {
                    unset($dest[$key]);
                }
            }

            return $dest;
        }

        return array(
        'sys' => systemConfig::$pathToSystem . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $subfolder,
        'app' => systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $subfolder
        );
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
