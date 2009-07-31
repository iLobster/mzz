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

fileLoader::load('orm/plugins/acl_extPlugin');

/**
 * adminMapper: маппер
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.9
 */

fileLoader::load('admin');

class adminMapper extends mapper
{
    protected $table = 'admin';
    protected $modules = array();

    public function __construct()
    {
        parent::__construct();
        $this->plugins('acl_ext');
    }

    /**
     * Метод получения общей инормации об установленных модулях, разделах и их отношений
     *
     * @return array
     */
    public function getInfo($order = false)
    {
        $toolkit = systemToolkit::getInstance();
        $user = $toolkit->getUser();

        $info = $this->db()->getAll('SELECT `m`.`name` AS `module`, `c`.`name` AS `class`, `m`.`id` AS `module_id`, `c`.`id` AS `class_id`, `m`.`title`, `m`.`icon`
                                      FROM `' . $this->db()->getTablePrefix() . 'sys_modules` `m`
                                       LEFT JOIN `' . $this->db()->getTablePrefix() . 'sys_classes` `c` ON `c`.`module_id` = `m`.`id`
                                        ORDER BY ' . ($order ? '`m`.`order`, ' : '') . '`m`.`name`, `c`.`name`');
        $result = array();

        $toolkit = systemToolkit::getInstance();

        foreach ($info as $val) {
            if (!isset($result[$val['module']])) {
                $obj_id = $toolkit->getObjectId('access_' . $val['module']);
                $this->register($obj_id, 'access');
                $acl = new acl($user, $obj_id);

                $result[$val['module']] = array(
                    'id' => $val['module_id'],
                    'title' => $val['title'],
                    'icon' => $val['icon'],
                    'obj_id' => $obj_id,
                    'editACL' => $acl->get('editACL'),
                    'editDefault' => $acl->get('editDefault'),
                    'admin' => $acl->get('admin'),
                    'classes' => array());
            }

            if (isset($val['class'])) {
                $result[$val['module']]['classes'][$val['class_id']] = $val['class'];
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
        return $this->db()->getRow('SELECT * FROM `' . $this->db()->getTablePrefix() . 'sys_classes` WHERE `id` = ' . (int)$id);
    }

    public function searchModuleById($id)
    {
        return $this->db()->getRow('SELECT * FROM `' . $this->db()->getTablePrefix() . 'sys_modules` WHERE `id` = ' . (int)$id);
    }

    /**
     * Поиск класса и модуля, которому принадлежит он, по идентификатору класса
     *
     * @param integer $id
     * @return array|boolean
     */
    public function searchClassWithModuleById($id)
    {
        return $this->db()->getRow('SELECT `c`.`name` AS `class_name`, `m`.`name` AS `module_name` FROM `' . $this->db()->getTablePrefix() . 'sys_classes` `c`
                                   INNER JOIN `' . $this->db()->getTablePrefix() . 'sys_modules` `m` ON `c`.`module_id` = `m`.`id`
                                    WHERE `c`.`id` = ' . (int)$id);
    }

    /**
     * Поиск классов, входящих в модуль, по id модуля
     *
     * @param integer $id
     * @return array|boolean
     */
    public function searchClassesByModuleId($id)
    {
        return $this->db()->getAll('SELECT * FROM `' . $this->db()->getTablePrefix() . 'sys_classes` WHERE `module_id` = ' . (int)$id, PDO::FETCH_ASSOC | PDO::FETCH_GROUP);
    }

    /**
     * Поиск класса по имени
     *
     * @param string $name
     * @return array|boolean
     */
    public function searchClassByName($name)
    {
        return $this->db()->getRow('SELECT * FROM `' . $this->db()->getTablePrefix() . 'sys_classes` WHERE `name` = ' . $this->db()->quote($name));
    }

    public function searchActionByNameAndClassId($name, $class_id)
    {
        return $this->db()->getRow('SELECT `a`.* FROM `' . $this->db()->getTablePrefix() . 'sys_actions` `a`
                                     INNER JOIN `' . $this->db()->getTablePrefix() . 'sys_classes_actions` `ca` ON `ca`.`action_id` = `a`.`id` AND `ca`.`class_id` = ' . (int)$class_id . '
                                      WHERE `a`.`name` = ' . $this->db()->quote($name));
    }

    public function searchActionByName($name)
    {
        return $this->db()->getRow('SELECT * FROM `' . $this->db()->getTablePrefix() . 'sys_actions` WHERE `name` = ' . $this->db()->quote($name));
    }

    /**
     * Поиск модуля, которому принадлежит класс
     *
     * @param integer $id id класса
     * @return array|boolean
     */
    public function searchModuleByClassId($id)
    {
        return $this->db()->getRow('SELECT `m`.* FROM `' . $this->db()->getTablePrefix() . 'sys_classes` `c`
                                     INNER JOIN `' . $this->db()->getTablePrefix() . 'sys_modules` `m` ON `m`.`id` = `c`.`module_id`
                                      WHERE `c`.`id` = ' . (int)$id);
    }

    public function searchModuleByClass($name)
    {
        return $this->db()->getRow('SELECT `m`.* FROM `' . $this->db()->getTablePrefix() . 'sys_classes` `c`
                                     INNER JOIN `' . $this->db()->getTablePrefix() . 'sys_modules` `m` ON `m`.`id` = `c`.`module_id`
                                      WHERE `c`.`name` = ' . $this->db()->quote($name));
    }

    /**
     * Метод получения списка модулей и классов, которые им принадлежат
     *
     * @return array
     */
    public function getModulesList()
    {
        $modules = $this->db()->getAll('SELECT COUNT(`ca`.`id`) AS `exists`, `m`.`name` AS `module`, `c`.`name` AS `class`, `m`.`id` AS `m_id`, `c`.`id` AS `c_id` FROM `' . $this->db()->getTablePrefix() . 'sys_modules` `m`
                                         LEFT JOIN `' . $this->db()->getTablePrefix() . 'sys_classes` `c` ON `c`.`module_id` = `m`.`id`
                                           LEFT JOIN `' . $this->db()->getTablePrefix() . 'sys_classes_actions` `ca` ON `ca`.`class_id` = `c`.`id` AND `ca`.`action_id` != 9
                                            GROUP BY `m`.`name`, `c`.`name`');

        $result = array();

        foreach ($modules as $val) {
            if (!isset($result[$val['m_id']])) {
                $result[$val['m_id']] = array(
                    'name' => $val['module'],
                    'classes' => array());
            }

            if (!is_null($val['class'])) {
                if (!$val['exists']) {
                    $action = new action($val['module']);
                    $actions = $action->getActions();
                    if (isset($actions[$val['class']]) && sizeof($actions[$val['class']]) > 1) {
                        $val['exists'] = 1;
                    }
                }

                $result[$val['m_id']]['classes'][$val['c_id']] = array(
                    'name' => $val['class'],
                    'exists' => $val['exists']);
            }
        }

        return $result;
    }

    /**
     * Метод получения списка модулей и классов, которые им принадлежат
     *
     * @return array
     */
    public function getModules()
    {
        if (empty($this->modules)) {
            $modules = $this->db()->getAll('SELECT `name`, `title` FROM `' . $this->db()->getTablePrefix() . 'sys_modules` `m` ORDER BY `order`, `name`', PDO::FETCH_ASSOC);
            foreach ($modules as $key => $values) {
                $this->modules[$values['name']] = $values['title'];
            }
        }
        return $this->modules;
    }

    /**
     * Получение списка классов
     *
     * @return array
     */
    public function getClasses()
    {
        $classes = $this->db()->getAll('SELECT `c`.`id`, `c`.`name` FROM `' . $this->db()->getTablePrefix() . 'sys_classes` `c`
                                       ORDER BY `c`.`name`', PDO::FETCH_ASSOC);
        $result = array();
        foreach ($classes as $class) {
            $result[$class['id']] = $class['name'];
        }
        return $result;
    }

    public static function getInfoByObjId($obj_id)
    {
        throw new mzzRuntimeException('deprecated');
        $db = DB::factory();

        $sql = 'SELECT `c`.`name` AS `class`, `m`.`name` AS `module`, `s`.`name` AS `section` FROM `' . $this->db()->getTablePrefix() . 'sys_access_registry` `r`
                 INNER JOIN `' . $this->db()->getTablePrefix() . 'sys_classes_sections` `cs` ON `cs`.`id` = `r`.`class_section_id`
                  INNER JOIN `' . $this->db()->getTablePrefix() . 'sys_classes` `c` ON `c`.`id` = `cs`.`class_id`
                   INNER JOIN `' . $this->db()->getTablePrefix() . 'sys_modules` `m` ON `m`.`id` = `c`.`module_id`
                    INNER JOIN `' . $this->db()->getTablePrefix() . 'sys_sections` `s` ON `s`.`id` = `cs`.`section_id`
                     WHERE `r`.`obj_id` = ' . (int)$obj_id;

        return $db->getRow($sql);
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
            if (strpos($method, 'search') === 0 || strpos($method, 'get') === 0) {
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

    public function getMethodInfo($class_id, $method)
    {
        $class = $this->searchClassWithModuleById($class_id);

        $toolkit = systemToolkit::getInstance();

        if (empty($class['class_name']) || empty($class['module_name'])) {
            return false;
        }

        $mapper = $class['class_name'] . 'Mapper';
        fileLoader::load($class['module_name'] . '/mappers/' . $mapper);

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
                            $docParams[$param[2]] = array(
                                trim($param[1]),
                                isset($param[3]) ? trim($param[3]) : '');
                        }
                    }
                } else {
                    $description .= $docblock . ' ';
                }
            }

            $params = array(
                'description' => $description);
            foreach ($reflect->getParameters() as $param) {
                if (isset($docParams[$param->getName()])) {
                    $docParam = $docParams[$param->getName()];
                } else {
                    $docParam = array(
                        'unknown',
                        'описание не указано');
                }
                $isScalar = !($param->isArray() || $param->getClass() != null || $param->isPassedByReference());
                $isScalarType = in_array($docParam[0], array(
                    'string',
                    'integer',
                    'boolean',
                    'float'));

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
                    $params[$param->getName()] = array(
                        $type,
                        $docParam[1],
                        false);
                } elseif ($isScalar && $isScalarType) {
                    $params[$param->getName()] = array(
                        $docParam[0],
                        $docParam[1],
                        true);
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
        $objects = $this->db()->getAll('SELECT `ar`.`obj_id`, `c`.`name` as `class_name` FROM `' . $this->db()->getTablePrefix() . 'sys_access_registry` `ar`
                                         LEFT JOIN `' . $this->db()->getTablePrefix() . 'sys_classes` `c` ON `c`.`id` = `ar`.`class_id`
                                          ORDER BY `ar`.`obj_id` DESC LIMIT 0, ' . (int)$items, PDO::FETCH_ASSOC);
        return $objects;
    }

    public function convertArgsToObj($args)
    {
        $toolkit = systemToolkit::getInstance();

        if (isset($args['module_name'])) {
            $obj_id = $toolkit->getObjectId('access_' . $args['module_name'], false);
        } else {
            $obj_id = $toolkit->getObjectId('access_admin');
            $this->register($obj_id);
        }

        $obj = $this->create();

        $obj->merge(array(
            'obj_id' => $obj_id));

        return $obj;
    }

    public function register($obj_id, $className = null)
    {
        if (is_null($className)) {
            $className = $this->class;
        }

        $toolkit = systemToolkit::getInstance();
        $acl = new acl($toolkit->getUser());
        $acl->register($obj_id, $className);
    }
}

?>