<?php


class moduleGenerator
{
    private $log = array();
    private $dest;

    public function __construct($dest)
    {
        $this->dest = $dest;

        define('CODEGEN', systemConfig::$pathToSystem . DIRECTORY_SEPARATOR . 'codegenerator');
        define('MZZ', systemConfig::$pathToApplication);
        define('CUR', $this->dest);
    }

    public function delete($module)
    {
        $this->safeUnlink(CUR . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $module);
    }

    public function safeUnlink($path)
    {
        $handle = opendir($path);

        while (false !== ($item = readdir($handle))) {
            if ($item != '.' && $item != '..') {
                $name = $path . DIRECTORY_SEPARATOR . $item;
                if (is_dir($name)) {
                    $this->safeUnlink($name);
                } else {
                    unlink($name);
                }
            }
        }
        closedir($handle);

        rmdir($path);
    }

    public function rename($oldName, $newName)
    {
        $current_dir = getcwd();
        chdir(CUR);
        rename($oldName, $newName);
        rename($newName . DIRECTORY_SEPARATOR . $oldName . 'Factory.php', $newName . DIRECTORY_SEPARATOR . $newName . 'Factory.php');
        chdir($current_dir);
    }

    public function generate($module)
    {
        $current_dir = getcwd();
        chdir(CUR);
        //define('MODULE_TEST_PATH', MZZ . 'tests/cases/modules/' . $module);

        //require_once MZZ . '/libs/smarty/Smarty.class.php';

        $smarty = new mzzSmarty();
        $smarty->template_dir = CODEGEN . DIRECTORY_SEPARATOR . 'templates';
        $smarty->force_compile = true;
        $smarty->compile_dir = systemConfig::$pathToTemp . DIRECTORY_SEPARATOR . 'templates_c';
        $smarty->left_delimiter = '{{';
        $smarty->right_delimiter = '}}';

        // создаем корневую папку модуля
        if (!is_dir( CUR . DIRECTORY_SEPARATOR . $module )) {
            mkdir($module, 0700);
            $this->log[] = "Корневой каталог модуля создан успешно";
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
            $this->log[] = "Каталог actions создан успешно";
        }

        // создаем папку controllers
        if (!is_dir('controllers')) {
            mkdir('controllers');
            $this->log[] = "Каталог controllers создан успешно";
        }
        // создаем папку mappers
        if (!is_dir('mappers')) {
            mkdir('mappers');
            $this->log[] = "Каталог mappers создан успешно";
        }
        // создаем папку maps
        if (!is_dir('maps')) {
            mkdir('maps');
            $this->log[] = "Каталог maps создан успешно";
        }
        // создаем папку views
        if (!is_dir('views')) {
            mkdir('views');
            $this->log[] = "Каталог views создан успешно";
        }


        $factoryData = array(
        'factory_name' => $factoryName,
        'module' => $module,
        );

        // записываем данные в файл фабрики
        $smarty->assign('factory_data', $factoryData);
        $factory = $smarty->fetch('factory.tpl');
        file_put_contents($factoryFilename, $factory);
        $this->log[] = 'Файл ' . $module . DIRECTORY_SEPARATOR . $factoryFilename . ' создан успешно';

        // создаем bat файлы для генерации ДО и actions в корневой папке модуля
        //$batSrc = explode(' ', file_get_contents('../create-module.bat'));

        // Если путь оносительный, то есть начинается  с точки, то предполагаем,
        // что генерируем модуль внутри mzz, а не в appDir
        /*$genDir = substr($batSrc[1],0, strrpos($batSrc[1], '\\'));
        if($genDir[0] == '.') {
        $genDir = '..\\' . $genDir;
        }*/

        /*
        $doGenerator = $genDir . '\createdo.php';
        $actionGenerator = $genDir . '\createaction.php';

        $genDoBat = $batSrc[0] . ' ' . $doGenerator . ' %1  %2';
        $genActionBat = $batSrc[0] . ' ' .  $actionGenerator . ' %1 %2';
        file_put_contents('create-do.bat', $genDoBat);
        file_put_contents('create-action.bat', $genActionBat);
        $log .= "\n-- create-do.bat";
        $log .= "\n-- create-action.bat";*/

        //file_put_contents('create_' . $module . '_module_log.txt', $log);
        //echo $log;

        chdir($current_dir);
        //throw new Exception("\n\nALL OPERATIONS COMPLETED SUCCESSFULLY\n");

        return $this->log;
    }
}

?>