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
 * actionGenerator: класс для генерации экшнов
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
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
        define('CUR', $this->dest . DIRECTORY_SEPARATOR . $this->module);
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

        $this->db->query($qry = 'INSERT INTO `sys_classes_actions` (`class_id`, `action_id`) VALUES (' . $res['id'] .', ' . $id . ')');
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
            chdir(CUR);

            $actionsfile = 'actions' . DIRECTORY_SEPARATOR . $this->class . '.ini';
            $data = parse_ini_file($actionsfile = 'actions' . DIRECTORY_SEPARATOR . $this->class . '.ini', true);

            if (isset($data[$action])) {
                unset($data[$action]);
            }

            $actions_output = "; " . $this->class . " actions config\r\n";

            foreach ($data as $section => $section_val) {
                $actions_output .= "\r\n[" . $section . "]\r\n";
                foreach ($section_val as $key => $val) {
                    $actions_output .= $key . " = \"" . $val . "\"\r\n";;
                }
            }

            file_put_contents($actionsfile, $actions_output);

            $this->safeUnlink('controllers' . DIRECTORY_SEPARATOR . $this->class . ucfirst($action) . 'Controller.php');
            $this->safeUnlink('views' . DIRECTORY_SEPARATOR . $this->class . ucfirst($action) . 'View.php');

            $this->safeUnlink(systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'act' . DIRECTORY_SEPARATOR . $this->module . DIRECTORY_SEPARATOR . $action . '.tpl');
            $this->safeUnlink(systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $this->module . DIRECTORY_SEPARATOR . $action . '.tpl');

            chdir($current_dir);
        }
    }

    /**
     * Метод для удаления файлов, с проверкой их существования
     *
     * @param string $filename
     */
    public function safeUnlink($filename)
    {
        if (file_exists($filename)) {
            unlink($filename);
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
        chdir(CUR);

        if ($oldName != $newName) {
            rename('controllers' . DIRECTORY_SEPARATOR . $this->module . ucfirst($oldName) . 'Controller.php', 'controllers' . DIRECTORY_SEPARATOR . $this->module . ucfirst($newName) . 'Controller.php');
            rename('views' . DIRECTORY_SEPARATOR . $this->module . ucfirst($oldName) . 'View.php', 'views' . DIRECTORY_SEPARATOR . $this->module . ucfirst($newName) . 'View.php');

            rename(systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'act' . DIRECTORY_SEPARATOR . $this->module . DIRECTORY_SEPARATOR . $oldName . '.tpl', systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'act' . DIRECTORY_SEPARATOR . $this->module . DIRECTORY_SEPARATOR . $newName . '.tpl');
            rename(systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $this->module . DIRECTORY_SEPARATOR . $oldName . '.tpl', systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $this->module . DIRECTORY_SEPARATOR . $newName . '.tpl');
        }

        $actionsfile = 'actions' . DIRECTORY_SEPARATOR . $this->class . '.ini';
        $data = parse_ini_file($actionsfile = 'actions' . DIRECTORY_SEPARATOR . $this->class . '.ini', true);

        $actions_output = $this->composeIniData($data, $params, $newName, $oldName);

        file_put_contents($actionsfile, $actions_output);

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

                $section_val['controller'] = $newName;

                if (!empty($params['jip'])) {
                    $section_val['jip'] = 1;
                }

                if (!empty($params['icon'])) {
                    $section_val['icon'] = $params['icon'];
                }

                if (empty($params['title'])) {
                    $params['title'] = $newName;
                }
                $section_val['title'] = $params['title'];

                if (!empty($params['confirm'])) {
                    $section_val['confirm'] = $params['confirm'];
                }

                if (!empty($params['inacl'])) {
                    $section_val['inACL'] = 0;
                }
            }
            $actions_output .= "\r\n[" . $section . "]\r\n";
            foreach ($section_val as $key => $val) {
                $actions_output .= $key . " = \"" . $val . "\"\r\n";;
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
        chdir(CUR);

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

        $prefix = $this->module . ucfirst($action);
        $controller_data = array(
        'action' => $action,
        'controllername' => $prefix . 'Controller',
        'module' => $this->module,
        'viewname' => $prefix . 'View',
        );

        $controller_filename = $controllers_dir . DIRECTORY_SEPARATOR . $this->module . ucfirst($action) . 'Controller.php';

        if (is_file($controller_filename)) {
            throw new Exception('Error: controller file already exists');
        }

        $views_dir = 'views';

        if (!is_dir($views_dir)) {
            throw new Exception("Error: Views directory '" . $views_dir . "' not found");
        }

        $view_data = array(
        'action' => $action,
        'viewname' => $prefix . 'View',
        'module' => $this->module,
        'tplname' => $this->module . DIRECTORY_SEPARATOR . $action . '.tpl',
        );

        $view_filename = $views_dir . DIRECTORY_SEPARATOR . $this->module . ucfirst($action) . 'View.php';

        if (is_file($view_filename)) {
            throw new Exception('Error: view file already exists');
        }

        $act_tpl_filename = systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'act' . DIRECTORY_SEPARATOR . $this->module . DIRECTORY_SEPARATOR . $action . '.tpl';

        if (is_file($act_tpl_filename)) {
            throw new Exception('Error: active template already exists');
        }

        $tpl_filename = systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $this->module . DIRECTORY_SEPARATOR . $action . '.tpl';

        if (is_file($tpl_filename)) {
            throw new Exception('Error: template already exists');
        }

        // записываем данные в actions файл
        file_put_contents($actionsfile, $actions_output);
        $this->log[] = $actionsfile;

        // записываем данные в файл контроллера
        $smarty->assign('controller_data', $controller_data);
        $controller = $smarty->fetch('controller.tpl');
        file_put_contents($controller_filename, $controller);
        $this->log[] = $controller_filename;

        // записываем данные в файл вида
        $smarty->assign('view_data', $view_data);
        $view = $smarty->fetch('view.tpl');
        file_put_contents($view_filename, $view);
        $this->log[] = $view_filename;

        // записываем данные в активный шаблон
        $smarty->assign('action', $action);
        $smarty->assign('module', $this->module);
        $act_tpl = $smarty->fetch('act.tpl');
        file_put_contents($act_tpl_filename, $act_tpl);
        $this->log[] = $act_tpl_filename;

        // записываем данные в активный шаблон
        $smarty->assign('action', $action);
        $smarty->assign('module', $this->module);
        $smarty->assign('path', $tpl_filename);
        $tpl = $smarty->fetch('template.tpl');
        file_put_contents($tpl_filename, $tpl);
        $this->log[] = $tpl_filename;

        chdir($current_dir);

        return $this->log;
    }
}

?>