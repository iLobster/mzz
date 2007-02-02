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
 * classGenerator: класс для генерации ДО
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

class classGenerator
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
     * Конструктор
     *
     * @param string $module
     * @param string $dest
     */
    public function __construct($module, $dest)
    {
        $this->module = $module;
        $this->dest = $dest;

        define('CODEGEN', systemConfig::$pathToSystem . DIRECTORY_SEPARATOR . 'codegenerator');
        define('MZZ', systemConfig::$pathToApplication);
        define('CUR', $this->dest . DIRECTORY_SEPARATOR . $this->module);
    }

    /**
     * Метод изменения имени ДО
     *
     * @param string $oldName старое имя
     * @param string $newName новое имя
     */
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

    /**
     * Удаление ДО
     *
     * @param string $class
     */
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

    /**
     * Метод для удаления файлов, с проверкой их существования
     *
     * @param string $filename
     */
    private function safeUnlink($filename)
    {
        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    /**
     * Метод генерации ДО
     *
     * @param string $class
     * @return array
     */
    public function generate($class)
    {
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

        // создаем ДО класс
        $doData = array(
        'doname' => $doName,
        'module' => $this->module,
        'mapper_name' => $mapperName
        );

        $smarty->assign('do_data', $doData);
        $factory = $smarty->fetch('do.tpl');
        file_put_contents($doNameFile, $factory);

        $this->log[] = $this->module . DIRECTORY_SEPARATOR . $doNameFile;

        // создаем маппер
        $mapperData = array(
        'doname' => $doName,
        'module' => $this->module,
        'mapper_name' => $mapperName
        );

        $smarty->assign('mapper_data', $mapperData);
        $mapper = $smarty->fetch('mapper.tpl');
        file_put_contents('mappers' . DIRECTORY_SEPARATOR . $mapperNameFile, $mapper);
        $this->log[] = $this->module . DIRECTORY_SEPARATOR . 'mappers' . DIRECTORY_SEPARATOR . $mapperNameFile;

        // создаем ini файл для экшнов
        $f = fopen('actions' . DIRECTORY_SEPARATOR . $iniFileName, 'w');
        fwrite($f, "; " . $doName . " actions config\r\n");
        fclose($f);
        $this->log[] = $this->module . DIRECTORY_SEPARATOR . 'actions' . DIRECTORY_SEPARATOR . $iniFileName;

        // создаем map файл
        $f = fopen('maps' . DIRECTORY_SEPARATOR . $mapFileName, 'w');
        fclose($f);
        $this->log[] = $this->module . DIRECTORY_SEPARATOR . 'maps' . DIRECTORY_SEPARATOR . $mapFileName . "\n";

        chdir($current_dir);

        return $this->log;
    }
}

?>