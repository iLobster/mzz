<?php

class actionGenerator
{
    private $log = array();
    private $module;
    private $dest;
    private $class;
    private $db;

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

    public function addToDB($action)
    {
        $res = $this->db->getRow('SELECT * FROM `sys_actions` WHERE `name` = ' . $this->db->quote($action));

        if (!$res) {
            $this->db->query('INSERT INTO `sys_actions` (`name`) VALUES (' . $this->db->quote($action) . ')');
            $id = $this->db->lastInsertId();
        } else {
            $id = $res['id'];
        }

        $res = $this->db->getRow('SELECT * FROM `sys_classes` WHERE `name` = ' . $this->db->quote($this->class));

        $this->db->query('INSERT INTO `sys_classes_actions` (`class_id`, `action_id`) VALUES (' . $res['id'] .', ' . $id . ')');
    }

    public function delete($action)
    {
        $res = $this->db->getRow('SELECT * FROM `sys_actions` WHERE `name` = ' . $this->db->quote($action));

        if ($res) {
            $id = $res['id'];
            $res = $this->db->getRow('SELECT * FROM `sys_classes` WHERE `name` = ' . $this->db->quote($this->class));

            $delete = $this->db->prepare('DELETE FROM `sys_classes_actions` WHERE `class_id` = ' . $res['id'] . ' AND `action_id` = ' . $id);
            $delete->execute();
            $deleted = $delete->rowCount();

            if ($deleted) {
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

                chdir($current_dir);
            }
        }
    }

    public function safeUnlink($filename)
    {
        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    public function rename($oldName, $newName)
    {
        $current_dir = getcwd();
        chdir(CUR);
        rename('controllers' . DIRECTORY_SEPARATOR . $this->class . ucfirst($oldName) . 'Controller.php', 'controllers' . DIRECTORY_SEPARATOR . $this->class . ucfirst($newName) . 'Controller.php');
        rename('views' . DIRECTORY_SEPARATOR . $this->class . ucfirst($oldName) . 'View.php', 'views' . DIRECTORY_SEPARATOR . $this->class . ucfirst($newName) . 'View.php');

        $actionsfile = 'actions' . DIRECTORY_SEPARATOR . $this->class . '.ini';
        $data = parse_ini_file($actionsfile = 'actions' . DIRECTORY_SEPARATOR . $this->class . '.ini', true);

        $actions_output = "; " . $this->class . " actions config\r\n";

        foreach ($data as $section => $section_val) {
            if ($section == $oldName) {
                $section = $newName;
                $section_val['controller'] = $newName;
            }
            $actions_output .= "\r\n[" . $section . "]\r\n";
            foreach ($section_val as $key => $val) {
                $actions_output .= $key . " = \"" . $val . "\"\r\n";;
            }
        }

        file_put_contents($actionsfile, $actions_output);

        $res = $this->db->getRow('SELECT * FROM `sys_actions` WHERE `name` = ' . $this->db->quote($oldName));
        if ($res) {
            $id = $res['id'];
            $res = $this->db->getRow('SELECT * FROM `sys_classes` WHERE `name` = ' . $this->db->quote($this->class));
            $this->db->query('DELETE FROM `sys_classes_actions` WHERE `class_id` = ' . $res['id'] . ' AND `action_id` = ' . $id);
        }

        $this->addToDB($newName);

        chdir($current_dir);
    }

    public function generate($action)
    {
        //define('CODEGEN', dirname(__FILE__));
        //define('MZZ', CODEGEN . '/../../');
        //define('CUR', getcwd());

        //$module = substr(strrchr(CUR, DIRECTORY_SEPARATOR), 1);

        $current_dir = getcwd();
        chdir(CUR);

        //require_once MZZ . 'libs/smarty/Smarty.class.php';

        $smarty = new mzzSmarty();
        $smarty->template_dir = CODEGEN . DIRECTORY_SEPARATOR . 'templates';
        $smarty->force_compile = true;
        $smarty->compile_dir = systemConfig::$pathToTemp . DIRECTORY_SEPARATOR . 'templates_c';
        $smarty->left_delimiter = '{{';
        $smarty->right_delimiter = '}}';
        chdir(getcwd());

        $type = $this->class;
        //$action = trim($argv[2]);
        $actionsfile = 'actions' . DIRECTORY_SEPARATOR . $type . '.ini';

        if (!is_file($actionsfile)) {
            throw new Exception("Error: Actions file '" . $type . ".ini' not found");
        }

        $data = parse_ini_file($actionsfile, true);

        if (isset($data[$action])) {
            throw new Exception("Error: action '" . $action . "' already exists in actions file");
        }

        if (strpos($type, $this->module) === 0 && $type !== $this->module) {
            $data[$action]['controller'] = strtolower(substr($type, strlen($this->module))) . ucfirst($action);
        } else {
            $data[$action]['controller'] = $action;
        }

        $actions_output = "; " . $type . " actions config\r\n";

        foreach ($data as $section => $section_val) {
            $actions_output .= "\r\n[" . $section . "]\r\n";
            foreach ($section_val as $key => $val) {
                $actions_output .= $key . " = \"" . $val . "\"\r\n";;
            }
        }

        $controllers_dir = 'controllers';

        if (!is_dir($controllers_dir)) {
            throw new Exception("Error: Controllers directory '" . $controllers_dir . "' not found");
        }

        $prefix = $type . ucfirst($action);
        $controller_data = array(
        'action' => $action,
        'controllername' => $prefix . 'Controller',
        'module' => $this->module,
        'viewname' => $prefix . 'View',
        );

        $controller_filename = $controllers_dir . DIRECTORY_SEPARATOR . $type . ucfirst($action) . 'Controller.php';

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

        $view_filename = $views_dir . DIRECTORY_SEPARATOR . $type . ucfirst($action) . 'View.php';

        if (is_file($view_filename)) {
            throw new Exception('Error: view file already exists');
        }

        //$this->log[] = "File edited successfully: ";
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
        //file_put_contents('create_' . $type . '_' . $action .'_action_log.txt', $log);

        //echo $log;
        chdir($current_dir);

        //throw new Exception("\n\nALL OPERATIONS COMPLETED SUCCESSFULLY\n");
        return $this->log;
    }
}

?>