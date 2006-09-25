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
 * @version $Id: createmodule.php 102 2006-09-24 23:30:32Z zerkms $
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
            $module = $argv[1];
        }        

        define('CODEGEN', dirname(__FILE__));
        define('MZZ', realpath(CODEGEN . '/../../') . '/');
        define('CUR', getcwd());      
        define('MODULE_TEST_PATH', MZZ . 'tests/cases/modules/' . $module);  
        
        

        require_once MZZ . '/libs/smarty/Smarty.class.php';

        $smarty = new Smarty();
        $smarty->template_dir = CODEGEN . '/templates';
        $smarty->force_compile = true;
        $smarty->compile_dir = MZZ . 'tmp';
        $smarty->left_delimiter = '{{';
        $smarty->right_delimiter = '}}';

        // ������� �������� ����� ������
        if (!is_dir( CUR . '/' . $module )) {
            mkdir($module, 0700);
            $log = "Module root folder created successfully:\n- " . $module;
        }
        chdir($module);
        // ������� ����� ��� ������
        
        if (!is_dir( MODULE_TEST_PATH )) {
            //echo "<pre>"; print_r(MODULE_TEST_PATH);echo "</pre>";
            mkdir(MODULE_TEST_PATH, 0700);
            $log .= "\nModule tests  folder created successfully:\n- " . str_replace(MZZ,'', MODULE_TEST_PATH);
        }        

        $factoryName = $module . 'Factory';
        $factoryFilename = $module . '.' . 'factory' . '.php';

        if (is_file($factoryFilename)) {
            throw new Exception('Error: factory file already exists');
        }        

        // ������� ����� actions
        if (!is_dir('actions')) {
            mkdir('actions');
            $log .= "\n\nFolder created successfully:\n- " . $module . "/actions";
        }

        // ������� ����� controllers
        if (!is_dir('controllers')) {
            mkdir('controllers');
            $log .= "\n- " . $module . '/controllers';
        }
        // ������� ����� mappers
        if (!is_dir('mappers')) {
            mkdir('mappers');
            $log .= "\n- " . $module . "/mappers";
        }
        // ������� ����� maps
        if (!is_dir('maps')) {
            mkdir('maps');
            $log .= "\n- " . $module . "/maps";
        }
        // ������� ����� views
        if (!is_dir('views')) {
            mkdir('views');
            $log .= "\n- " . $module . "/views";
        }
        
        // ������� ����� ��� ������ ������
        if (!is_dir('views')) {
            mkdir('views');
            $log .= "\n- " . $module . "/views";
        }        


        $factoryData = array(
                'factory_name' => $factoryName,
                'module' => $module,
                );

         // ���������� ������ � ���� �������
        $smarty->assign('factory_data', $factoryData);
        $factory = $smarty->fetch('factory.tpl');
        file_put_contents($factoryFilename, $factory);
        $log .= "\n\nFile created successfully:\n- " . $module . '/' . $factoryFilename;

         // ������� bat ����� ��� ��������� �� � actions � �������� ����� ������
        $batSrc = explode(' ', file_get_contents('../generateModule.bat'));
        $genDoBat = $batSrc[0] . ' ..\..\codegenerator\createdo.php %1';
        $genActionBat = $batSrc[0] . ' ..\..\codegenerator\createaction.php %1 %2';
        file_put_contents('generateDO.bat', $genDoBat);
        file_put_contents('generateAction.bat', $genActionBat);
        $log .= "\n- generateDO.bat";
        $log .= "\n- generateAction.bat";

        //file_put_contents('create_' . $module . '_module_log.txt', $log);
        echo $log;

        throw new Exception('All operations completed successfully');
} catch (Exception $e) {
    die($e->getMessage());
}

?>