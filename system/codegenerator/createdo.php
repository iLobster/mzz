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

// createdo.php     Creates Domain Object needed files


try {
        if (!isset($argv[1]) || $argv[1] == '-h') {
            throw new Exception('This tool is used for generating blank files and casesfor new module

createdo.php name

name         name of DO
createTest   (optional)

Sample usage:

    > createdo.php  news
    Creates files needed of news module :
        - create file with DO class: news.php
        - create file with mapper class: newsMapper.php
        - create ini file with map : news.ini
        - create case file for DO and his mapper: tests/cases/modules/news/news.case.php and newsMapper.case.php' );
        }

        define('CODEGEN', dirname(__FILE__));
        //define('CODEGEN_TEMPLATES', dirname(__FILE__) . '/templates/');
        define('MZZ', realpath(CODEGEN . '/../../'));
        define('CUR', getcwd());

        $module = substr(strrchr(CUR, DIRECTORY_SEPARATOR), 1);

        define('MODULE_TEST_PATH', MZZ . '/tests/cases/modules/' . $module . '/' );
        define('MODULE_TEST_SHORT_PATH', str_replace(MZZ, '', MODULE_TEST_PATH));


        require_once MZZ . '/libs/smarty/Smarty.class.php';

        $smarty = new Smarty();
        $smarty->template_dir = CODEGEN . '/templates';
        $smarty->force_compile = true;
        $smarty->compile_dir = MZZ . '/tmp/templates_c';
        $smarty->left_delimiter = '{{';
        $smarty->right_delimiter = '}}';

        if (!isset($argv[1])) {
            throw new Exception('Error: parameter 1 \'name\' not specified. use -h for view help');
        } else {
            $doName = $argv[1];
        }


        $doNameFile = $doName . '.php';
        if (is_file($doNameFile)) {
            throw new Exception('Error: DO file[' . $doNameFile . '] already exists');
        }

        $mapperName = $doName . 'Mapper';
        $mapperNameFile = $mapperName . '.php';
        if (is_file('mappers/' . $mapperNameFile)) {
            throw new Exception('Error: mapper file[' . $mapperNameFile . '] already exists');
        }

        $mapFileName = $doName . '.map.ini';
        if (is_file('maps/' . $mapFileName)) {
            throw new Exception('Error: map ini file[' . $mapFileName . '] already exists');
        }

        $iniFileName = $doName . '.ini';
        if (is_file('actions/' . $iniFileName)) {
            throw new Exception('Error: actions ini file[' . $iniFileName . '] already exists');
        }


        $doCaseFileName = $doName . '.case.php';
        if (is_file(MODULE_TEST_PATH . $doCaseFileName)) {
            throw new Exception('Error: do.case file file[' . $doCaseFileName . '] already exists');
        }

        $doMapperCaseFileName = $doName . 'Mapper.case.php';
        if (is_file(MODULE_TEST_PATH . $doMapperCaseFileName)) {
            throw new Exception('Error: mapper.case file[' . $doMapperCaseFileName . '] already exists');
        }

        // -------создаем ДО класс-----------
        $doData = array(
                'doname' => $doName,
                'module' => $module,
                'mapper_name' => $mapperName
                );

        $smarty->assign('do_data', $doData);
        $factory = $smarty->fetch('do.tpl');
        file_put_contents($doNameFile, $factory);

        $log = '';

        $log .= "File created successfully:\n- " . $module . '/' . $doNameFile;


        // -------создаем маппер-----------


        $mapperData = array(
                'doname' => $doName,
                'module' => $module,
                'mapper_name' => $mapperName
                );

        $smarty->assign('mapper_data', $mapperData);
        $mapper = $smarty->fetch('mapper.tpl');
        file_put_contents('mappers/' . $mapperNameFile, $mapper);
        $log .= "\n- " .$module . '/mappers/' . $mapperNameFile;

        // -------(optional)создаем шаблоны тестов для ДО и маппера-----------
        // @toDo можно сделать довольно полную генерацию тестов
        // но для этого необходимо делать отдельный генератор, который создаст тест для ДО и маппера
        // на основе данных о полях из map.ini
        if(isset($argv[2])) {
            if (!is_dir( MODULE_TEST_PATH )) {                //echo "<pre>"; print_r(MODULE_TEST_PATH);echo "</pre>";
                mkdir(MODULE_TEST_PATH, 0700);
                $log .= "\nModule tests  folder created successfully:\n- " . str_replace(MZZ,'', MODULE_TEST_PATH);
            }
            $doCaseData = array(
                'doName' => $doName,
                'module' => $module,
                'tableName' => strtolower($module . '_' . $doName),
                'mapperName' => $mapperName
                );
            $smarty->assign('doCaseData', $doCaseData);
            $case = $smarty->fetch('do_case.tpl');
            file_put_contents(MODULE_TEST_PATH . '/' . $doCaseFileName, $case);
            $log .= "\n- " . MODULE_TEST_SHORT_PATH . '/' . $doCaseFileName;

            $smarty->assign('doCaseData', $doCaseData);
            $mapperCase = $smarty->fetch('domapper_case.tpl');
            file_put_contents(MODULE_TEST_PATH . $doMapperCaseFileName, $mapperCase);
            $log .= "\n- " . MODULE_TEST_SHORT_PATH . $doMapperCaseFileName;
        }


        // -------создаем ini файл для экшинов-----------

        $f = fopen('actions/' . $iniFileName, 'w');
        fclose($f);
        $log .= "\n- " .$module . '/actions/' . $iniFileName;

        // -------создаем map файл -----------
        $f = fopen('maps/' . $mapFileName, 'w');
        fclose($f);
        $log .= "\n- " .$module . '/maps/' . $mapFileName . "\n";

        //file_put_contents('create_' . $doName . '_do_for_' . $module . '_module_log.txt', $log);

        echo $log;

        throw new Exception("\n\nALL OPERATIONS COMPLETED SUCCESSFULLY\n");
} catch (Exception $e) {
    die($e->getMessage());
}
?>