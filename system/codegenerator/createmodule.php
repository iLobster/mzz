<?php
/**
 * $URL: http://svn.web/repository/mzz/system/codegenerator/createmodule.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: createmodule.php 420 2006-12-11 23:11:56Z zerkms $
*/

// createmodule.php     moduleName      name

try {
        if (!isset($argv[1]) || $argv[1] == '-h') {
            throw new Exception('This tool is used for generating blank files for new module

createmodule.php name

name          name of module

Sample usage:

    > createmodule.php  news
    Creates folders needed of news module :
        - create root folder of module: news
        - create needed folder into root folder of module:
            - actions
            - controllers
            - mappers
            - maps
            - views' );
        }


        if (!isset($argv[1])) {
            throw new Exception('Error: parameter 1 \'name\' not specified. use -h for view help');
        } else {
            $module = trim($argv[1]);
        }

        define('CODEGEN', dirname(__FILE__));
        define('MZZ', realpath(CODEGEN . '/../../') . '/');
        define('CUR', getcwd());
        define('MODULE_TEST_PATH', MZZ . 'tests/cases/modules/' . $module);

        require_once MZZ . '/libs/smarty/Smarty.class.php';

        $smarty = new Smarty();
        $smarty->template_dir = CODEGEN . '/templates';
        $smarty->force_compile = true;
        $smarty->compile_dir = MZZ . 'tmp/templates_c';
        $smarty->left_delimiter = '{{';
        $smarty->right_delimiter = '}}';

        // создаем корневую папку модуля
        if (!is_dir( CUR . '/' . $module )) {
            mkdir($module, 0700);
            $log = "Module root folder created successfully:\n-- " . $module;
        }
        chdir($module);
        // создаем папку для тестов

        $factoryName = $module . 'Factory';
        $factoryFilename = $factoryName . '.php';

        if (is_file($factoryFilename)) {
            throw new Exception('Error: factory file already exists');
        }

        // создаем папку actions
        if (!is_dir('actions')) {
            mkdir('actions');
            $log .= "\n\nFolder created successfully:\n-- " . $module . "/actions";
        }

        // создаем папку controllers
        if (!is_dir('controllers')) {
            mkdir('controllers');
            $log .= "\n-- " . $module . '/controllers';
        }
        // создаем папку mappers
        if (!is_dir('mappers')) {
            mkdir('mappers');
            $log .= "\n-- " . $module . "/mappers";
        }
        // создаем папку maps
        if (!is_dir('maps')) {
            mkdir('maps');
            $log .= "\n-- " . $module . "/maps";
        }
        // создаем папку views
        if (!is_dir('views')) {
            mkdir('views');
            $log .= "\n-- " . $module . "/views";
        }


        $factoryData = array(
                'factory_name' => $factoryName,
                'module' => $module,
                );

         // записываем данные в файл фабрики
        $smarty->assign('factory_data', $factoryData);
        $factory = $smarty->fetch('factory.tpl');
        file_put_contents($factoryFilename, $factory);
        $log .= "\n\nFile created successfully:\n-- " . $module . '/' . $factoryFilename;

         // создаем bat файлы для генерации ДО и actions в корневой папке модуля
        $batSrc = explode(' ', file_get_contents('../create-module.bat'));

        // Если путь оносительный, то есть начинается  с точки, то предполагаем,
        // что генерируем модуль внутри mzz, а не в appDir
        $genDir = substr($batSrc[1],0, strrpos($batSrc[1], '\\'));
        if($genDir[0] == '.') {
            $genDir = '..\\' . $genDir;
        }


        $doGenerator = $genDir . '\createdo.php';
        $actionGenerator = $genDir . '\createaction.php';

        $genDoBat = $batSrc[0] . ' ' . $doGenerator . ' %1  %2';
        $genActionBat = $batSrc[0] . ' ' .  $actionGenerator . ' %1 %2';
        file_put_contents('create-do.bat', $genDoBat);
        file_put_contents('create-action.bat', $genActionBat);
        $log .= "\n-- create-do.bat";
        $log .= "\n-- create-action.bat";

        //file_put_contents('create_' . $module . '_module_log.txt', $log);
        echo $log;

        throw new Exception("\n\nALL OPERATIONS COMPLETED SUCCESSFULLY\n");
} catch (Exception $e) {
    die($e->getMessage());
}

?>