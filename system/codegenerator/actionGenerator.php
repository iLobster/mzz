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

fileLoader::load('codegenerator/safeGenerate');

/**
 * actionGenerator: класс для генерации экшнов
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.8
 */
class actionGenerator
{
    /**
     * Массив для хранения сообщений
     *
     * @var array
     */
    private $log = array();

    /**
     * Имя модуля
     *
     * @var string
     */
    private $module;

    /**
     * Путь до каталога, в который будут сгенерированы файлы
     *
     * @var string
     */
    private $dest;

    /**
     * Имя класса
     *
     * @var string
     */
    private $class;

    /**
     * Класс работы с БД
     *
     * @var mzzPDO
     */
    private $db;

    /**
     * Конструктор
     *
     * @param string $module
     * @param string $dest
     * @param string $class
     */
    public function __construct($module, $dest, $class)
    {
        $this->module = $module;
        $this->dest = $dest;
        $this->class = $class;
        $this->db = DB::factory();

        define('CODEGEN', systemConfig::$pathToSystem . DIRECTORY_SEPARATOR . 'codegenerator');
        define('MZZ', systemConfig::$pathToApplication);
        define('CUR_DEST_FOLDER', $this->dest . DIRECTORY_SEPARATOR . $this->module);
    }

    /**
     * Метод получения информации об экшне по имени
     *
     * @param string $name
     * @return array
     */
    private function getAction($name)
    {
        return $this->db->getRow('SELECT * FROM `sys_actions` WHERE `name` = ' . $this->db->quote($name));
    }

    /**
     * Метод получения информаци о классе по имени
     *
     * @param string $name
     * @return array
     */
    private function getClass($name)
    {
        return $this->db->getRow('SELECT * FROM `sys_classes` WHERE `name` = ' . $this->db->quote($name));
    }

    /**
     * Добавление в БД информации об экшне
     *
     * @param string $action
     */
    public function addToDB($action)
    {
        $res = $this->getAction($action);

        if (!$res) {
            $this->db->query('INSERT INTO `sys_actions` (`name`) VALUES (' . $this->db->quote($action) . ')');
            $id = $this->db->lastInsertId();
        } else {
            $id = $res['id'];
        }

        $res = $this->getClass($this->class);

        $this->db->query($qry = 'INSERT INTO `sys_classes_actions` (`class_id`, `action_id`) VALUES (' . $res['id'] . ', ' . $id . ')');
    }

    /**
     * Удаление экшна
     *
     * @param string $action
     */
    public function delete($action)
    {
        $res = $this->getAction($action);

        if ($res) {
            $id = $res['id'];
            $res = $this->getClass($this->class);

            $delete = $this->db->prepare('DELETE FROM `sys_classes_actions` WHERE `class_id` = ' . $res['id'] . ' AND `action_id` = ' . $id);
            $delete->execute();
            $deleted = $delete->rowCount();

            $current_dir = getcwd();
            chdir(CUR_DEST_FOLDER);

            $actionsfile = 'actions' . DIRECTORY_SEPARATOR . $this->class . '.ini';
            $data = parse_ini_file($actionsfile, true);

            if (isset($data[$action])) {
                unset($data[$action]);
            }

            $actions_output = "; " . $this->class . " actions config\r\n";

            foreach ($data as $section => $section_val) {
                $actions_output .= "\r\n[" . $section . "]\r\n";
                foreach ($section_val as $key => $val) {
                    $actions_output .= $key . " = \"" . $val . "\"\r\n";
                }
            }

            file_put_contents($actionsfile, $actions_output);

            // удаляем контроллер
            safeGenerate::delete('controllers' . DIRECTORY_SEPARATOR . $this->module . ucfirst($action) . 'Controller.php');
            // удаляем шаблон
            safeGenerate::delete('templates' . DIRECTORY_SEPARATOR . $action . '.tpl');

            safeGenerate::delete(systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'act' . DIRECTORY_SEPARATOR . $this->module . DIRECTORY_SEPARATOR . $action . '.tpl');

            chdir($current_dir);
        }
    }

    /**
     * Метод изменения имени для экшна
     *
     * @param string $oldName старое имя
     * @param string $newName новое имя
     * @param array $params массив дополнительных свойств экшна
     */
    public function rename($oldName, $newName, $params)
    {
        $current_dir = getcwd();
        chdir(CUR_DEST_FOLDER);

        $data = array();

        if ($oldName != $newName) {
            $oldPath = 'controllers' . DIRECTORY_SEPARATOR . $this->module . ucfirst($oldName) . 'Controller.php';
            $newPath = 'controllers' . DIRECTORY_SEPARATOR . $this->module . ucfirst($newName) . 'Controller.php';

            $controllerCode = file_get_contents($oldPath);
            $controllerCode = str_replace($oldName, $newName, $controllerCode);
            $controllerCode = str_replace(ucfirst($oldName), ucfirst($newName), $controllerCode);

            $data[] = array($oldPath, $newPath, $controllerCode);

            if (is_file($tmp = systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'act' . DIRECTORY_SEPARATOR . $this->module . DIRECTORY_SEPARATOR . $oldName . '.tpl')) {
                $code = file_get_contents($tmp);
                $code = str_replace($oldName, $newName, $code);

                $data[] = array($tmp, systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'act' . DIRECTORY_SEPARATOR . $this->module . DIRECTORY_SEPARATOR . $newName . '.tpl', $code);
            }
            if (is_file($tmp = 'templates' . DIRECTORY_SEPARATOR . $oldName . '.tpl')) {
                $data[] = array($tmp, 'templates' . DIRECTORY_SEPARATOR . $newName . '.tpl');
            }
        }

        $actionsfile = 'actions' . DIRECTORY_SEPARATOR . $this->class . '.ini';
        $actions = parse_ini_file($actionsfile = 'actions' . DIRECTORY_SEPARATOR . $this->class . '.ini', true);

        $actions_output = $this->composeIniData($actions, $params, $newName, $oldName);

        $data[] = array($actionsfile, $actionsfile, $actions_output);

        safeGenerate::rename($data);

        $res = $this->getAction($oldName);
        if ($res) {
            $id = $res['id'];
            $res = $this->getClass($this->class);
            $this->db->query($q = 'DELETE FROM `sys_classes_actions` WHERE `class_id` = ' . $res['id'] . ' AND `action_id` = ' . $id);
        }

        $this->addToDB($newName);

        chdir($current_dir);
    }

    /**
     * Метод формирования данных ini-файла
     *
     * @param array $data массив с данными для файла
     * @param array $params массив с дополнительными параметрами
     * @param string $newName старое имя экшна
     * @param string $oldName новое имя экшна
     * @return string результирующая строка
     */
    private function composeIniData($data, $params, $newName, $oldName)
    {
        $actions_output = "; " . $this->class . " actions config\r\n";

        foreach ($data as $section => $section_val) {
            if ($section == $oldName) {
                $section = $newName;

                unset($section_val);

                if (!empty($params['controller'])) {
                    $section_val['controller'] = $params['controller'];
                } else {
                    $section_val['controller'] = $newName;
                }

                if (!empty($params['jip'])) {
                    $section_val['jip'] = 1;
                }

                if (!empty($params['icon'])) {
                    $section_val['icon'] = $params['icon'];
                }

                if (!empty($params['title'])) {
                    $section_val['title'] = $params['title'];
                }

                if (!empty($params['confirm'])) {
                    $section_val['confirm'] = $params['confirm'];
                }

                if (!empty($params['403handle'])) {
                    $section_val['403handle'] = $params['403handle'];
                }

                if (!empty($params['alias'])) {
                    $section_val['alias'] = $params['alias'];
                }

                if (!empty($params['lang'])) {
                    $section_val['lang'] = 1;
                }
            }
            $actions_output .= "\r\n[" . $section . "]\r\n";
            foreach ($section_val as $key => $val) {
                $actions_output .= $key . " = " . ((is_numeric($val)) ? $val : '"' . $val . '"') . "\r\n";
            }
        }

        return $actions_output;
    }

    /**
     * Метод генераци экшна
     *
     * @param string $action
     * @param array $params
     * @return array
     */
    public function generate($action, $params)
    {
        $current_dir = getcwd();
        chdir(CUR_DEST_FOLDER);

        $smarty = new Smarty();
        $smarty->template_dir = CODEGEN . DIRECTORY_SEPARATOR . 'templates';
        $smarty->force_compile = true;
        $smarty->compile_dir = systemConfig::$pathToTemp . DIRECTORY_SEPARATOR . 'templates_c';
        $smarty->left_delimiter = '{{';
        $smarty->right_delimiter = '}}';

        $actionsfile = 'actions' . DIRECTORY_SEPARATOR . $this->class . '.ini';

        if (!is_file($actionsfile)) {
            throw new Exception("Error: Actions file '" . $this->class . ".ini' not found");
        }

        $data = parse_ini_file($actionsfile, true);

        if (isset($data[$action])) {
            throw new Exception("Error: action '" . $action . "' already exists in actions file");
        }

        if (strpos($this->class, $this->module) === 0 && $this->class !== $this->module) {
            $data[$action]['controller'] = strtolower(substr($this->class, strlen($this->module))) . ucfirst($action);
        } else {
            $data[$action]['controller'] = $action;
        }

        $actions_output = $this->composeIniData($data, $params, $action, $action);

        $controllers_dir = 'controllers';

        if (!is_dir($controllers_dir)) {
            throw new Exception("Error: Controllers directory '" . $controllers_dir . "' not found");
        }

        $controller_name = (isset($params['controller']) && !empty($params['controller']) ? $params['controller'] : $action);
        $prefix = $this->module . ucfirst($controller_name);
        $controller_data = array('action' => $action, 'controllername' => $prefix . 'Controller', 'module' => $this->module, 'viewname' => $prefix . 'View');

        $controller_filename = $controllers_dir . DIRECTORY_SEPARATOR . $prefix . 'Controller.php';

        $act_tpl_filename = systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'act' . DIRECTORY_SEPARATOR . $this->module . DIRECTORY_SEPARATOR . $action . '.tpl';

        if (is_file($act_tpl_filename)) {
            throw new Exception('Error: active template already exists');
        }

        if (!is_dir($tpl_filename = 'templates')) {
            $tpl_filename = systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $this->module;
        }

        $skip_tpl = false;
        if (isset($params['tpl_as_controller']) && $params['tpl_as_controller']) {
            if (is_file($tpl_filename = $tpl_filename . DIRECTORY_SEPARATOR . $controller_name . '.tpl')) {
                $skip_tpl = true;
            }
        } else {
            if (is_file($tpl_filename = $tpl_filename . DIRECTORY_SEPARATOR . $action . '.tpl')) {
                throw new Exception('Error: template already exists');
            }
        }

        // записываем данные в файл контроллера, предварительно проверив, не был ли создан этот контроллер ранее
        if (!is_file($controller_filename)) {
            $smarty->assign('controller_data', $controller_data);
            $controller = $smarty->fetch('controller.tpl');
        }

        // записываем данные в активный шаблон
        $smarty->assign('action', $action);
        $smarty->assign('module', $this->module);
        $act_tpl = $smarty->fetch('act.tpl');

        if (!$skip_tpl) {
            // записываем данные в пассивный шаблон
            $smarty->assign('action', $action);
            $smarty->assign('module', $this->module);
            $smarty->assign('path', $tpl_filename);
            $tpl = $smarty->fetch('template.tpl');
        }

        // запись в файлы


        $data = array();

        // actions
        $data[] = array($actionsfile, $actions_output);
        $this->log[] = $actionsfile;
        // controller
        if (isset($controller)) {
            $data[] = array($controller_filename, $controller);
            $this->log[] = $controller_filename;
        }
        // act_tpl
        $data[] = array($act_tpl_filename, $act_tpl);
        $this->log[] = $act_tpl_filename;
        // tpl
        if (isset($tpl)) {
            $data[] = array($tpl_filename, $tpl);
            $this->log[] = $tpl_filename;
        } else {
            $this->log[] = $tpl_filename . ' <strong>[skipped]</strong>';
        }

        safeGenerate::write($data);

        chdir($current_dir);

        return $this->log;
    }
}

?>