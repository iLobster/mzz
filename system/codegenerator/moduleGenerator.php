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
 * moduleGenerator: класс для генерации модуля
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.3
 */
class moduleGenerator
{
    /**
     * Массив для хранения сообщений
     *
     * @var array
     */
    private $log = array();

    /**
     * Путь до каталога, в который будут сгенерированы файлы
     *
     * @var string
     */
    private $dest;

    /**
     * Конструктор
     *
     * @param string $dest
     */
    public function __construct($dest)
    {
        $this->dest = $dest;

        define('CODEGEN', systemConfig::$pathToSystem . DIRECTORY_SEPARATOR . 'codegenerator');
        define('MZZ', systemConfig::$pathToApplication);
        define('CUR', $this->dest);
    }

    /**
     * Удаление модуля
     *
     * @param string $module
     */
    public function delete($module)
    {
        $this->safeUnlink(CUR . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $module);
        $this->safeUnlink(systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'act' . DIRECTORY_SEPARATOR . $module);
    }

    /**
     * Метод рекурсивного удаления каталога с файлами и подкаталогами в нём
     *
     * @param string $path
     */
    private function safeUnlink($path)
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

    /**
     * Переименование модуля
     *
     * @param string $oldName
     * @param string $newName
     */
    public function rename($oldName, $newName)
    {
        $current_dir = getcwd();
        chdir(CUR);

        $data = array();

        $data[] = array($oldName, $newName);
        $data[] = array($newName . DIRECTORY_SEPARATOR . $oldName . 'Factory.php', $newName . DIRECTORY_SEPARATOR . $newName . 'Factory.php');
        $data[] = array(systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'act' . DIRECTORY_SEPARATOR . $oldName, systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'act' . DIRECTORY_SEPARATOR . $newName);

        safeGenerate::renameDir($data);

        chdir($current_dir);
    }

    /**
     * Генерация модуля
     *
     * @param string $module
     * @return array
     */
    public function generate($module)
    {
        $current_dir = getcwd();
        chdir(CUR);

        $smarty = new mzzSmarty();
        $smarty->template_dir = CODEGEN . DIRECTORY_SEPARATOR . 'templates';
        $smarty->force_compile = true;
        $smarty->compile_dir = systemConfig::$pathToTemp . DIRECTORY_SEPARATOR . 'templates_c';
        $smarty->left_delimiter = '{{';
        $smarty->right_delimiter = '}}';

        if (!is_writeable(CUR)) {
            throw new mzzRuntimeException('Нет доступа на запись в каталог ' . CUR);
        }

        // создаем корневую папку модуля
        if (!is_dir(CUR . DIRECTORY_SEPARATOR . $module)) {
            mkdir($module, 0700);
            $this->log[] = "Корневой каталог модуля создан успешно";
        }
        chdir($module);

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

        // создаём папку с шаблонами
        if (!is_dir('templates')) {
            mkdir('templates');
            $this->log[] = "Каталог templates создан успешно";
        }

        $factoryData = array('factory_name' => $factoryName, 'module' => $module);

        // записываем данные в файл фабрики
        $smarty->assign('factory_data', $factoryData);
        $factory = $smarty->fetch('factory.tpl');
        file_put_contents($factoryFilename, $factory);
        $this->log[] = 'Файл ' . $module . DIRECTORY_SEPARATOR . $factoryFilename . ' создан успешно';

        // создаём папку с активными шаблонами
        if (!is_dir(systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'act' . DIRECTORY_SEPARATOR . $module)) {
            mkdir(systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'act' . DIRECTORY_SEPARATOR . $module);
            $this->log[] = "Каталог для активных шаблонов создан";
        }

        chdir($current_dir);

        return $this->log;
    }
}

?>