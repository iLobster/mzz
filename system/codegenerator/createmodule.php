<?php

// createmodule.php     moduleName      name

try {
        if (!isset($argv[1]) || $argv[1] == '-h') {
            throw new Exception('This tool is used for generating blank files for new module

createmodule.php name

name          ame of module

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

        define('CODEGEN', dirname(__FILE__));
        define('MZZ', CODEGEN . '/../../');
        define('CUR', getcwd());

        require_once MZZ . 'libs/smarty/Smarty.class.php';

        $smarty = new Smarty();
        $smarty->template_dir = CODEGEN . '/templates';
        $smarty->force_compile = true;
        $smarty->compile_dir = MZZ . 'tmp';
        $smarty->left_delimiter = '{{';
        $smarty->right_delimiter = '}}';

        if (!isset($argv[1])) {
            throw new Exception('Error: parameter 1 \'name\' not specified. use -h for view help');
        } else {
            $module = $argv[1];
        }

        // создаем корневую папку модуля
        if (!is_dir(CUR . '/' . $module)) {
            mkdir($module, 0700);
            $log = "Module root folder created successfully:\n- " . $module;
        }
        chdir($module);

        // создаем папку actions
        if (!is_dir('actions')) {
            mkdir('actions');
            $log .= "\n\nFolder created successfully:\n- " . $module . "/actions";
        }

        // создаем папку controllers
        if (!is_dir('controllers')) {
            mkdir('controllers');
            $log .= "\n- " . $module . '/controllers';
        }
        // создаем папку mappers
        if (!is_dir('mappers')) {
            mkdir('mappers');
            $log .= "\n- " . $module . "/mappers";
        }
        // создаем папку maps
        if (!is_dir('maps')) {
            mkdir('maps');
            $log .= "\n- " . $module . "/maps";
        }
        // создаем папку views
        if (!is_dir('views')) {
            mkdir('views');
            $log .= "\n- " . $module . "/views";
        }


        $factoryName = $module . 'Factory';
        $factoryFilename = $module . '.' . 'factory' . '.php';

        if (is_file($factoryFilename)) {
            throw new Exception('Error: factory file already exists');
        }

        $factoryData = array(
                'factory_name' => $factoryName,
                'module' => $module,
                );

         // записываем данные в файл фабрики
        $smarty->assign('factory_data', $factoryData);
        $factory = $smarty->fetch('factory.tpl');
        file_put_contents($factoryFilename, $factory);
        $log .= "\n\nFile created successfully:\n- " .$module . '/' . $factoryFilename;

         // создаем батники в модуле
        $batSrc = explode(' ', file_get_contents('../generateModule.bat'));
        $genDoBat = $batSrc[0] . '  ..\..\codegenerator\createdo.php ' . $module;
        $genActionBat = $batSrc[0] . '  ..\..\codegenerator\createaction.php ' . $module . ' action';
        file_put_contents('1_generateDO.bat', $genDoBat);
        file_put_contents('2_generateAction.bat', $genActionBat);
        $log .= "\n- 1_generateDO.bat";
        $log .= "\n- 2_generateAction.bat";

        file_put_contents('create_' . $module . '_module_log.txt', $log);

        throw new Exception('All operations completed successfully');
} catch (Exception $e) {
    die($e->getMessage());
}
?>