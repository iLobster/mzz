<?php

class classGenerator
{
    private $log = array();
    private $module;
    private $dest;

    public function __construct($module, $dest)
    {
        $this->module = $module;
        $this->dest = $dest;

        define('CODEGEN', systemConfig::$pathToSystem . DIRECTORY_SEPARATOR . 'codegenerator');
        define('MZZ', systemConfig::$pathToApplication);
        define('CUR', $this->dest . DIRECTORY_SEPARATOR . $this->module);
    }

    public function rename($oldName, $newName)
    {
        $current_dir = getcwd();
        chdir(CUR);
        rename($oldName . '.php', $newName . '.php');
        rename('mappers' . DIRECTORY_SEPARATOR . $oldName . 'Mapper.php', 'mappers' . DIRECTORY_SEPARATOR . $newName . 'Mapper.php');
        rename('actions' . DIRECTORY_SEPARATOR . $oldName . '.ini', 'actions' . DIRECTORY_SEPARATOR . $newName . '.ini');
        rename('maps' . DIRECTORY_SEPARATOR . $oldName . '.map.ini', 'maps' . DIRECTORY_SEPARATOR . $newName . '.map.ini');
        chdir($current_dir);
    }

    public function delete($class)
    {
        $current_dir = getcwd();
        chdir(CUR);
        $this->safeUnlink($class . '.php');
        $this->safeUnlink('mappers' . DIRECTORY_SEPARATOR . $class . 'Mapper.php');
        $this->safeUnlink('actions' . DIRECTORY_SEPARATOR . $class . '.ini');
        $this->safeUnlink('maps' . DIRECTORY_SEPARATOR . $class . '.map.ini');
        chdir($current_dir);
    }

    private function safeUnlink($filename)
    {
        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    public function generate($class)
    {
        //define('MODULE_TEST_PATH', MZZ . '/tests/cases/modules/' . $module . '/' );
        //define('MODULE_TEST_SHORT_PATH', str_replace(MZZ, '', MODULE_TEST_PATH));

        $current_dir = getcwd();
        chdir(CUR);

        $smarty = new mzzSmarty();
        $smarty->template_dir = CODEGEN . DIRECTORY_SEPARATOR . 'templates';
        $smarty->force_compile = true;
        $smarty->compile_dir = systemConfig::$pathToTemp . DIRECTORY_SEPARATOR . 'templates_c';
        $smarty->left_delimiter = '{{';
        $smarty->right_delimiter = '}}';

        $doName = $class;
        $doNameFile = $doName . '.php';

        if (is_file($doNameFile)) {
            throw new Exception('Error: DO file[' . $doNameFile . '] already exists');
        }

        $mapperName = $doName . 'Mapper';
        $mapperNameFile = $mapperName . '.php';
        if (is_file('mappers' . DIRECTORY_SEPARATOR . $mapperNameFile)) {
            throw new Exception('Error: mapper file[' . $mapperNameFile . '] already exists');
        }

        $mapFileName = $doName . '.map.ini';
        if (is_file('maps' . DIRECTORY_SEPARATOR . $mapFileName)) {
            throw new Exception('Error: map ini file[' . $mapFileName . '] already exists');
        }

        $iniFileName = $doName . '.ini';
        if (is_file('actions' . DIRECTORY_SEPARATOR . $iniFileName)) {
            throw new Exception('Error: actions ini file[' . $iniFileName . '] already exists');
        }


        /*        $doCaseFileName = $doName . '.case.php';
        if (is_file(MODULE_TEST_PATH . $doCaseFileName)) {
        throw new Exception('Error: do.case file file[' . $doCaseFileName . '] already exists');
        }

        $doMapperCaseFileName = $doName . 'Mapper.case.php';
        if (is_file(MODULE_TEST_PATH . $doMapperCaseFileName)) {
        throw new Exception('Error: mapper.case file[' . $doMapperCaseFileName . '] already exists');
        }*/

        // -------создаем ДО класс-----------
        $doData = array(
        'doname' => $doName,
        'module' => $this->module,
        'mapper_name' => $mapperName
        );

        $smarty->assign('do_data', $doData);
        $factory = $smarty->fetch('do.tpl');
        file_put_contents($doNameFile, $factory);

        $this->log[] = $this->module . DIRECTORY_SEPARATOR . $doNameFile;


        // -------создаем маппер-----------


        $mapperData = array(
        'doname' => $doName,
        'module' => $this->module,
        'mapper_name' => $mapperName
        );

        $smarty->assign('mapper_data', $mapperData);
        $mapper = $smarty->fetch('mapper.tpl');
        file_put_contents('mappers' . DIRECTORY_SEPARATOR . $mapperNameFile, $mapper);
        $this->log[] = $this->module . DIRECTORY_SEPARATOR . 'mappers' . DIRECTORY_SEPARATOR . $mapperNameFile;

        // -------(optional)создаем шаблоны тестов для ДО и маппера-----------
        // @toDo можно сделать довольно полную генерацию тестов
        // но для этого необходимо делать отдельный генератор, который создаст тест для ДО и маппера
        // на основе данных о полях из map.ini
        /*  if(isset($argv[2])) {
        if (!is_dir( MODULE_TEST_PATH )) {
        //echo "<pre>"; print_r(MODULE_TEST_PATH);echo "</pre>";
        mkdir(MODULE_TEST_PATH, 0700);
        $log .= "\nModule tests  folder created successfully:\n-- " . str_replace(MZZ,'', MODULE_TEST_PATH);
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
        $log .= "\n-- " . MODULE_TEST_SHORT_PATH . '/' . $doCaseFileName;

        $smarty->assign('doCaseData', $doCaseData);
        $mapperCase = $smarty->fetch('domapper_case.tpl');
        file_put_contents(MODULE_TEST_PATH . $doMapperCaseFileName, $mapperCase);
        $log .= "\n-- " . MODULE_TEST_SHORT_PATH . $doMapperCaseFileName;
        }*/


        // -------создаем ini файл для экшнов-----------

        $f = fopen('actions' . DIRECTORY_SEPARATOR . $iniFileName, 'w');
        fwrite($f, "; " . $doName . " actions config\r\n");
        fclose($f);
        $this->log[] = $this->module . DIRECTORY_SEPARATOR . 'actions' . DIRECTORY_SEPARATOR . $iniFileName;

        // -------создаем map файл -----------
        $f = fopen('maps' . DIRECTORY_SEPARATOR . $mapFileName, 'w');
        fclose($f);
        $this->log[] = $this->module . DIRECTORY_SEPARATOR . 'maps' . DIRECTORY_SEPARATOR . $mapFileName . "\n";

        chdir($current_dir);

        return $this->log;
    }
}

?>