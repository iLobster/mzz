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

// createaction.php     type            action
// createaction.php     newsFolder      editFolder
try {
        if (!isset($argv[1]) || $argv[1] == '-h') {
            throw new Exception('This tool is used for generating blank files for new module action

createaction.php type action

type            the type of object action created for
action          the creating action\'s name

Sample usage:

    > createaction.php news edit
    Creates action edit for news type object:
        - adds new section into actions/news.ini
        - creates controllers/news.edit.controller.php
        - creates views/news.edit.view.php');
        }

        define('CODEGEN', dirname(__FILE__));
        define('MZZ', CODEGEN . '/../../');
        define('CUR', getcwd());

        $module = substr(strrchr(CUR, DIRECTORY_SEPARATOR), 1);

        require_once MZZ . 'libs/smarty/Smarty.class.php';

        $smarty = new Smarty();
        $smarty->template_dir = CODEGEN . '/templates';
        $smarty->force_compile = true;
        $smarty->compile_dir = MZZ . 'tmp/templates_c';
        $smarty->left_delimiter = '{{';
        $smarty->right_delimiter = '}}';
        chdir(getcwd());

        if (!is_dir('actions')) {
            throw new Exception('Error: Actions directory not found');
        }

        if (!isset($argv[1])) {
            throw new Exception('Error: parameter 1 \'type\' not specified. use -h for view help');
        }

        if (!isset($argv[2])) {
            throw new Exception('Error: parameter 2 \'action\' not specified. use -h for view help');
        }

        $type = $argv[1];
        $action = $argv[2];
        $actionsfile = 'actions/' . $type . '.ini';

        if (!is_file($actionsfile)) {
            throw new Exception("Error: Actions file '" . $type . " .ini' not found");
        }

        $data = parse_ini_file($actionsfile, true);

        if (isset($data[$action])) {
            throw new Exception("Error: action '" . $action . "' already exists in actions file");
        }

        $data[$action]['controller'] = $action;

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
                'module' => $module,
                'viewname' => $prefix . 'View',
                );

        $controller_filename = $controllers_dir . '/' . $type . '.' . $action . '.controller.php';

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
                'module' => $module,
                'tplname' => $type . '.' . $action . '.tpl',
                );

        $view_filename = $views_dir . '/' . $type . '.' . $action . '.view.php';

        if (is_file($view_filename)) {
            throw new Exception('Error: view file already exists');
        }

        $log = "File edited successfully: ";
        // записываем данные в actions файл
        file_put_contents($actionsfile, $actions_output);
        $log .= "\n- " . $actionsfile;

        $log .= "\n\nFile created successfully: ";
        // записываем данные в файл контроллера
        $smarty->assign('controller_data', $controller_data);
        $controller = $smarty->fetch('controller.tpl');
        file_put_contents($controller_filename, $controller);
        $log .= "\n- " . $controller_filename;

        // записываем данные в файл вида
        $smarty->assign('view_data', $view_data);
        $view = $smarty->fetch('view.tpl');
        file_put_contents($view_filename, $view);

        $log .= "\n- " . $view_filename;
        //file_put_contents('create_' . $type . '_' . $action .'_action_log.txt', $log);

        echo $log;

        throw new Exception("\n\nALL OPERATIONS COMPLETED SUCCESSFULLY\n");
} catch (Exception $e) {
    die($e->getMessage());
}
?>