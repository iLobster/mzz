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

fileLoader::load('codegenerator/safeGenerate');

/**
 * classGenerator: класс для генерации ДО
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.1
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
     * @param array $templates
     */
    public function __construct($module, $dest, $templates = null)
    {
        $this->module = $module;
        $this->dest = $dest;
        $this->templates = $templates;

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

        $data = array();

        $data[] = array($oldName . '.php', $newName . '.php');
        $data[] = array('mappers' . DIRECTORY_SEPARATOR . $oldName . 'Mapper.php', 'mappers' . DIRECTORY_SEPARATOR . $newName . 'Mapper.php');
        $data[] = array('actions' . DIRECTORY_SEPARATOR . $oldName . '.ini', 'actions' . DIRECTORY_SEPARATOR . $newName . '.ini');
        $data[] = array('maps' . DIRECTORY_SEPARATOR . $oldName . '.map.ini', 'maps' . DIRECTORY_SEPARATOR . $newName . '.map.ini');

        safeGenerate::rename($data);

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
        safeGenerate::delete($class . '.php');
        safeGenerate::delete('mappers' . DIRECTORY_SEPARATOR . $class . 'Mapper.php');
        safeGenerate::delete('actions' . DIRECTORY_SEPARATOR . $class . '.ini');
        safeGenerate::delete('maps' . DIRECTORY_SEPARATOR . $class . '.map.ini');
        chdir($current_dir);
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

        $data = array();

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

        $template_name = 'do.tpl';
        if (!empty($this->templates['do'])) {
            $template_name = $this->templates['do'];
        }

        $factory = $smarty->fetch($template_name);
        $data[] = array($doNameFile, $factory);

        $this->log[] = $this->module . DIRECTORY_SEPARATOR . $doNameFile;

        // создаем маппер
        $mapperData = array(
        'doname' => $doName,
        'module' => $this->module,
        'mapper_name' => $mapperName
        );

        $smarty->assign('mapper_data', $mapperData);

        $template_name = 'mapper.tpl';
        if (!empty($this->templates['mapper'])) {
            $template_name = $this->templates['mapper'];
        }
        $mapper = $smarty->fetch($template_name);

        $data[] = array('mappers' . DIRECTORY_SEPARATOR . $mapperNameFile, $mapper);
        $this->log[] = $this->module . DIRECTORY_SEPARATOR . 'mappers' . DIRECTORY_SEPARATOR . $mapperNameFile;

        // создаем ini файл для экшнов
        $data[] = array('actions' . DIRECTORY_SEPARATOR . $iniFileName, "; " . $doName . " actions config\r\n");
        $this->log[] = $this->module . DIRECTORY_SEPARATOR . 'actions' . DIRECTORY_SEPARATOR . $iniFileName;

        // создаем map файл
        $data[] = array('maps' . DIRECTORY_SEPARATOR . $mapFileName, '');
        $this->log[] = $this->module . DIRECTORY_SEPARATOR . 'maps' . DIRECTORY_SEPARATOR . $mapFileName . "\n";

        safeGenerate::write($data);

        chdir($current_dir);

        return $this->log;
    }
}

?>