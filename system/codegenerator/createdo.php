<?php

// createdo.php     Creates Domain Object needed files

try {
        if (!isset($argv[1]) || $argv[1] == '-h') {
            throw new Exception('This tool is used for generating blank files for new module

createdo.php name

name         name of DO

Sample usage:

    > createdo.php  news
    Creates files needed of news module :
        - create file with DO class: news.php
        - create file with mapper class: newsMapper.php
        - create ini file with map : news.ini' );
        }

        define('CODEGEN', dirname(__FILE__));
        define('MZZ', CODEGEN . '/../../');
        define('CUR', getcwd());

        $module = substr(strrchr(CUR, DIRECTORY_SEPARATOR), 1);

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
            $doName = $argv[1];
        }


        $doNameFile = $doName . '.php';
        if (is_file($doNameFile)) {
            throw new Exception('Error: DO file[' . $doNameFile . '] already exists');
        }

        $mapperName = $doName . 'Mapper';
        $mapperNameFile = $mapperName . '.php';
        if (is_file('mappers/' . $mapperNameFile)) {
            throw new Exception('Error: mapper file['.$mapperNameFile.'] already exists');
        }

        $mapFileName = $doName . '.map.ini';
        if (is_file('maps/' . $mapFileName)) {
            throw new Exception('Error: map ini file['.$mapFileName.'] already exists');
        }

        $iniFileName = $doName . '.ini';
        if (is_file('actions/' . $iniFileName)) {
            throw new Exception('Error: actions ini file['.$iniFileName.'] already exists');
        }

        // -------создаем ДО класс-----------
        $doData = array(
                'doname' => $doName,
                'module' => $module,
                );

        $smarty->assign('do_data', $doData);
        $factory = $smarty->fetch('do.tpl');
        file_put_contents($doNameFile, $factory);
        $log .= "File created successfully:\n- " .$module . '/' . $doNameFile;


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

        // -------создаем ini файл для экшинов-----------

        $f = fopen('actions/' . $iniFileName, 'w');
        fclose($f);
        $log .= "\n- " .$module . '/actions/' . $iniFileName;

        // -------создаем map файл -----------
        $f = fopen('maps/' . $mapFileName, 'w');
        fclose($f);
        $log .= "\n- " .$module . '/maps/' . $mapFileName;


        file_put_contents('create_' . $doName . '_do_for_' . $module . '_module_log.txt', $log);

        throw new Exception('All operations completed successfully');
} catch (Exception $e) {
    die($e->getMessage());
}
?>