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
 * @version 0.1.9
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
            /*if (!$val['section']) {
            $class_info = $this->searchClassByName($val['class']);
            $this->registerClassInSections($class_info['id']);
            }*/

            $class = (!empty($val['main_class'])) ? $val['main_class'] : $val['class'];

            $main[$val['module']] = $class;

            if (isset($val['section']) && isset($val['class'])) {
                $obj_id = $toolkit->getObjectId('access_' . $val['section'] . '_' . $class);
                $this->register($obj_id, 'sys', 'access');
                $acl = new acl($user, $obj_id);


                $access[$val['section'] . '_' . $val['module']] = $acl->get('editACL');

                $action = $toolkit->getAction($val['module']);
                $actions = $action->getActions();
                $actions = $actions[$val['class']];

                $admin[$val['section'] . '_' . $val['class']] = isset($actions['admin']) && $acl->get('admin');

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
            if (!empty($val['section'])) {
                $class = $val['main_class'];

                $obj_id = $toolkit->getObjectId('access_' . $val['section'] . '_' . $class);

                $this->register($obj_id, 'sys', 'access');
                $acl = new acl($user, $obj_id);

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
     * Поиск класса по id
     *
     * @param integer $id
     * @return array|boolean
     */
    public function searchClassById($id)
    {
        return $this->db->getRow("SELECT * FROM `sys_classes` WHERE `id` = " . (int)$id);
    }

    /**
     * Поиск класса и модуля, которому принадлежит он, по идентификатору класса
     *
     * @param integer $id
     * @return array|boolean
     */
    public function searchClassWithModuleById($id)
    {
        return $this->db->getRow("SELECT `c`.`name` AS `class_name`, `m`.`name` AS `module_name` FROM `sys_classes` `c`
                                   INNER JOIN `sys_modules` `m` ON `c`.`module_id` = `m`.`id`
                                    WHERE `c`.`id` = " . (int)$id);
    }

    /**
     * Возвращает имя класса, модуля, секции в которых он находится по идентификаторам
     *
     * @param integer $section
     * @param integer $module
     * @param integer $class
     * @return array|boolean
     */
    public function getNamesOfSectionModuleClass($section, $module, $class)
    {
        return $this->db->getAll('SELECT `s`.`name` AS `section_name` , `m`.`name` AS `module_name` , `c`.`name` AS `class_name`
                                   FROM `sys_sections` `s`
                                    INNER JOIN `sys_classes_sections` `cs` ON `cs`.`section_id` = `s`.`id`
                                     INNER JOIN `sys_classes` `c` ON `c`.`id` = `cs`.`class_id` AND `c`.`id` =  ' . (int)$class . '
                                      INNER JOIN `sys_modules` `m` ON `m`.`id` = `c`.`module_id` AND `m`.`id` = ' . (int)$module . '
                                       WHERE `s`.`id` = ' . (int)$section);

    }

    /**
     * Поиск классов, входящих в модуль, по id модуля
     *
     * @param integer $id
     * @return array|boolean
     */
    public function searchClassesByModuleId($id)
    {
        return $this->db->getAll('SELECT * FROM `sys_classes` WHERE `module_id` = ' . (int)$id, PDO::FETCH_ASSOC | PDO::FETCH_GROUP);
    }

    /**
     * Поиск класса по имени
     *
     * @param string $name
     * @return array|boolean
     */
    public function searchClassByName($name)
    {
        return $this->db->getRow("SELECT * FROM `sys_classes` WHERE `name` = " . $this->db->quote($name));
    }

    /**
     * Поиск модуля, которому принадлежит класс
     *
     * @param integer $id id класса
     * @return array|boolean
     */
    public function searchModuleByClassId($id)
    {
        return $this->db->getRow('SELECT `m`.* FROM `sys_classes` `c`
                                   INNER JOIN `sys_modules` `m` ON `m`.`id` = `c`.`module_id`
                                    WHERE `c`.`id` = ' . (int)$id);
    }

    /**
     * Поиск модулей, которые зарегистрированы в секции
     *
     * @param integer $id id секции
     * @return array|boolean
     */
    public function searchModulesBySection($id)
    {
        return $this->db->getAll('SELECT DISTINCT `m`.`id`, `m`.`name` FROM `sys_classes_sections` `cs`
                                   LEFT JOIN `sys_classes` `c` ON `c`.`id` = `cs`.`class_id`
                                    INNER JOIN `sys_modules` `m` ON `m`.`id` = `c`.`module_id`
                                     WHERE `cs`.`section_id` = ' . (int)$id, PDO::FETCH_ASSOC | PDO::FETCH_GROUP);
    }

    /**
     * Регистрация класса в секциях, в которых зарегистрирован модуль, в который входит класс. Происходит при создании нового класса
     *
     * @param integer $class_id
     */
    public function registerClassInSections($class_id)
    {
        $module = $this->searchModuleByClassId($class_id);
        $sections = $this->getSectionsModuleRegistered($module['id']);

        $insert = '';
        foreach ($sections as $val) {
            $insert .= '(' . $val['id'] . ', ' . $class_id . '), ';
        }

        $insert = substr($insert, 0, -2);

        if ($insert) {
            $this->db->query('INSERT INTO `sys_classes_sections` (`section_id`, `class_id`) VALUES ' . $insert);
        }
    }

    /**
     * Удаление класса из всех секций, в которых он был зарегистрирован
     *
     * @param integer $class_id
     */
    public function deleteClassFromSections($class_id)
    {
        $module = $this->searchModuleByClassId($class_id);
        $sections = $this->getSectionsModuleRegistered($module['id']);

        $delete = array();
        foreach ($sections as $val) {
            $delete[] = $val['id'];
        }

        if ($delete) {
            $this->db->query('DELETE FROM `sys_classes_sections` WHERE `class_id` = ' . (int)$class_id . ' AND `section_id` IN (' . implode(', ', $delete) . ')');
        }
    }

    /**
     * Список секций, в которых зарегистрирован модуль
     *
     * @param integer|string $module если значение не число, то поиск производится по имени модуля
     * @return array
     */
    public function getSectionsModuleRegistered($module)
    {
        $where = '`m`.' . (is_numeric($module) ? '`id` = ' . (int)$module : '`name` = ' . $this->db->quote($module));
        return $this->db->getAll('SELECT `s`.* FROM `sys_modules` `m`
                                    INNER JOIN `sys_classes` `c` ON `c`.`module_id` = `m`.`id`
                                     INNER JOIN `sys_classes_sections` `cs` ON `cs`.`class_id` = `c`.`id`
                                      INNER JOIN `sys_sections` `s` ON `s`.`id` = `cs`.`section_id`
                                       WHERE ' . $where . '
                                        GROUP BY `s`.`id`');
    }

    /**
     * Список модулей, которые зарегистрированы в секции
     *
     * @param integer $section_id
     * @return array
     */
    public function getModulesAtSection($section_id)
    {
        $stmt = $this->db->query('SELECT `m`.`id` AS `m_id`, `m`.`name` AS `m_name`, `cs`.`section_id` IS NOT NULL AS `checked` FROM `sys_classes` `c`
                                     INNER JOIN `sys_modules` `m` ON `m`.`id` = `c`.`module_id`
                                      LEFT JOIN `sys_classes_sections` `cs` ON `cs`.`class_id` = `c`.`id` AND `cs`.`section_id` = ' . (int)$section_id . '
                                       GROUP BY `m`.`id`
                                        ORDER BY `m`.`name`');

        $result = array();
        while ($tmp = $stmt->fetch()) {
            $result[$tmp['m_id']] = $tmp;
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
                                           LEFT JOIN `sys_classes_actions` `ca` ON `ca`.`class_id` = `c`.`id` AND `ca`.`action_id` != 9
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
     * Метод получения списка модулей, секций и классов, которые им принадлежат
     *
     * @return array
     */
    public function getSectionsAndModulesWithClasses()
    {
        $modules = $this->db->getAll('SELECT `s`.`id` AS `section_id`, `s`.`name` AS `section_name`, `m`.`name` AS `module_name`,
                                       `c`.`name` AS `class_name` FROM `sys_sections` `s`
                                        LEFT JOIN `sys_classes_sections` `cs` ON `cs`.`section_id` = `s`.`id`
                                         LEFT JOIN `sys_classes` `c` ON `c`.`id` = `cs`.`class_id`
                                          LEFT JOIN `sys_modules` `m` ON `m`.`id` = `c`.`module_id`');

        $result = array();

        foreach ($modules as $val) {
            if (!empty($val['module_name'])) {
                $result[$val['section_name']]['modules'][$val['module_name']][] = $val['class_name'];
            } else {
                $result[$val['section_name']]['modules'] = array();
            }
            if (!isset($result[$val['section_name']]['id'])) {
                $result[$val['section_name']]['id'] = $val['section_id'];
            }
        }

        return $result;
    }

    /**
     * Получение списка секций и классов для конкретного модуля
     *
     * @return array
     */
    public function getModuleSectionsAndClasses($module)
    {
        $modules = $this->db->getAll('SELECT `s`.`id` AS `section_id`, `s`.`name` AS `section_name` FROM `sys_sections` `s`
                                        LEFT JOIN `sys_classes_sections` `cs` ON `cs`.`section_id` = `s`.`id`
                                         LEFT JOIN `sys_classes` `c` ON `c`.`id` = `cs`.`class_id`
                                          LEFT JOIN `sys_modules` `m` ON `m`.`id` = `c`.`module_id`
                                           WHERE `m`.`name` = ' . $this->db->quote($module));

        $result = array();

        foreach ($modules as $val) {
            if (!isset($result[$val['section_name']]['id'])) {
                $result[$val['section_name']]['id'] = $val['section_id'];
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
     * Получение списка классов в секциях
     *
     * @return array
     */
    public function getClassesInSections()
    {
        $classes = $this->db->getAll("SELECT `cs`.`id`, `c`.`name` as `class_name`, `s`.`name` as `section_name` FROM `sys_classes_sections` `cs`
                                               LEFT JOIN `sys_classes` `c` ON `c`.`id` = `cs`.`class_id`
                                                LEFT JOIN `sys_sections` `s` ON `s`.`id` = `cs`.`section_id`
                                                 ORDER BY `s`.`name`, `c`.`name`", PDO::FETCH_ASSOC);
        $result = array();
        foreach ($classes as $class) {
            $result[$class['section_name']][] = array('id' => $class['id'], 'class' => $class['class_name']);
        }
        return $result;
    }

    /**
     * Получение списка get* и search* методов маппера
     *
     * @param integer $class_id идентификатор класса
     * @return array
     */
    public function getSearchMethods($class_id)
    {
        $class = $this->searchClassWithModuleById($class_id);

        $toolkit = systemToolkit::getInstance();

        if (empty($class['class_name']) || empty($class['module_name'])) {
            return null;
        }

        $mapper = $class['class_name'] . 'Mapper';
        fileLoader::load($class['module_name'] . '/mappers/' . $mapper);

        if (!class_exists($mapper)) {
            return null;
        }

        $methods = get_class_methods($mapper);
        $result = array();
        foreach ($methods as $method) {
            // @todo возможно нужно использовать stripos
            if (strpos($method, 'search') === 0 || strpos($method, 'get') === 0) {
                // убрано в отдельное условие
                $reflect = new ReflectionMethod($mapper, $method);
                if ($reflect->isPublic()) {
                    $valid = true;
                    foreach ($reflect->getParameters() as $param) {
                        if (!$param->isOptional() && ($param->isArray() || $param->getClass() != null || $param->isPassedByReference())) {
                            $valid = false;
                            break;
                        }
                    }
                    if ($valid) {
                        $result[] = $method;
                    }
                }
            }
        }
        sort($result);
        return $result;
    }

    /**
     * Получение геттеров (методы для получения данных) доменного объекта
     *
     * @param string|integer $class_id идентификатор или имя класса
     * @return array
     */
    public function getClassExtractMethods($class)
    {
        if (preg_match('/^\d+$/', $class)) {
            $class = $this->searchClassById($class);
        } else {
            $class = $this->searchClassByName($class);
        }
        if (empty($class)) {
            return null;
        }

        $module = $this->searchModuleByClassId($class['id']);
        if (empty($module)) {
            return null;
        }

        $toolkit = systemToolkit::getInstance();
        $mapper = $toolkit->getMapper($module['name'], $class['name']);
        $accessors = array();
        foreach ($mapper->getMap() as $key => $val) {
            $accessors[] = $val['accessor'];
        }
        return $accessors;
    }

    /*
    public function getExtractMethods($module)
    {
    if (empty($module['id']) || empty($module['name'])) {
    return null;
    }

    $classes = $this->searchClassesByModuleId($module['id']);
    if (empty($classes)) {
    return null;
    }

    $toolkit = systemToolkit::getInstance();

    $accessors = array();
    foreach ($classes as $class) {
    $mapper = $toolkit->getMapper($module['name'], $class[0]['name']);
    $map = $mapper->getMap();
    foreach ($map as $key => $val) {
    $accessors[$class[0]['name']][] = $val['accessor'];
    }
    }

    return $accessors;
    }*/

    public function getMethodInfo($class_id, $method)
    {
        $class = $this->searchClassWithModuleById($class_id);

        $toolkit = systemToolkit::getInstance();

        if (empty($class['class_name']) || empty($class['module_name'])) {
            return false;
        }

        $mapper = $class['class_name'] . 'Mapper';
        fileLoader::load($class['module_name'] . '/mappers/' . $mapper);

        // @todo функция method_exists может принимать первым аргументом имя класса, а не объект, но
        // в php-документации это пока не отражено
        if (!class_exists($mapper) || !method_exists($mapper, $method)) {
            return false;
        }

        $reflect = new ReflectionMethod($mapper, $method);
        if ($reflect->isPublic()) {
            $docComment = $reflect->getDocComment();
            preg_match_all('#^\s*\*\s*(.*?)$#mU', $docComment, $matches);
            $docblocks = $matches[1];
            $docParams = array();
            $description = '';
            foreach ($docblocks as $docblock) {
                $docblock = trim($docblock);
                if (empty($docblock) || $docblock[0] == '/') {
                    continue;
                }
                if ($docblock[0] == '@') {
                    if (substr($docblock, 0, 6) == '@param') {
                        $param = preg_split('/\s+/', $docblock, 4);
                        if (count($param) >= 3) {
                            $param[2] = substr(trim($param[2]), 1);
                            $docParams[$param[2]] = array(trim($param[1]), isset($param[3]) ? trim($param[3]) : '');
                        }
                    }
                } else {
                    $description .= $docblock . ' ';
                }
            }

            $params = array('description' => $description);
            foreach ($reflect->getParameters() as $param) {
                if (isset($docParams[$param->getName()])) {
                    $docParam = $docParams[$param->getName()];
                } else {
                    $docParam = array('unknown', 'описание не указано');
                }
                $isScalar = !($param->isArray() || $param->getClass() != null || $param->isPassedByReference());
                $isScalarType = in_array($docParam[0], array('string', 'integer', 'boolean', 'float'));

                // один из параметров не скалярный и обязательный, вызов невозможен
                if (!$param->isOptional() && (!$isScalar || !$isScalarType)) {
                    $params = null;
                    break;
                }

                if (!$isScalar || !$isScalarType) {
                    if ($param->isArray()) {
                        $type = 'array';
                    } elseif ($param->getClass() != null && ($class_name = $param->getClass()->getName())) {
                        $type = $class_name;
                    } else {
                        $type = $docParam[0];
                    }
                    $params[$param->getName()] = array($type, $docParam[1], false);
                } elseif ($isScalar && $isScalarType) {
                    $params[$param->getName()] = array($docParam[0], $docParam[1], true);
                }

                if ($param->isOptional()) {
                    $defaultValue = $param->getDefaultValue();
                    $params[$param->getName()][3] = is_scalar($defaultValue) ? $defaultValue : (string)$defaultValue;
                }
            }

        }

        return $params;
    }

    /**
     * Получение последних зарегистрированных в ACL объектов
     *
     * @param integer $items число элементов
     * @return array
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

    /**
     * Получение списка каталогов, используемых для генерации модулей
     *
     * @param boolean $onlyWritable показывать только те, для которых есть права на запись
     * @param string $subfolder подкаталог в каталоге modules, права на запись в который будет проверяться
     * @return array
     */
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

    public function convertArgsToObj($args)
    {
        $toolkit = systemToolkit::getInstance();

        if (isset($args['section_name']) && isset($args['module_name'])) {
            $main_class = $this->getMainClass($args['module_name']);
            $obj_id = $toolkit->getObjectId('access_' . $args['section_name'] . '_' . $main_class, false);

            $obj = $this->create();
        } else {
            $obj_id = $toolkit->getObjectId('access_admin_admin');
            $this->register($obj_id);

            $obj = $this->create();
        }

        $obj->import(array('obj_id' => $obj_id));

        return $obj;
    }
}

?>