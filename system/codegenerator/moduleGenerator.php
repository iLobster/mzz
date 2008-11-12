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
 * @version 0.1.4
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

        // создаем папку actions
        if (!is_dir('actions')) {
            mkdir('actions');
            $this->log[] = "Каталог <strong>actions</strong> создан успешно";
        }

        // создаем папку controllers
        if (!is_dir('controllers')) {
            mkdir('controllers');
            $this->log[] = "Каталог <strong>controllers</strong> создан успешно";
        }
        // создаем папку mappers
        if (!is_dir('mappers')) {
            mkdir('mappers');
            $this->log[] = "Каталог <strong>mappers</strong> создан успешно";
        }
        // создаем папку maps
        if (!is_dir('maps')) {
            mkdir('maps');
            $this->log[] = "Каталог <strong>maps</strong> создан успешно";
        }

        // создаём папку с шаблонами
        if (!is_dir('templates')) {
            mkdir('templates');
            $this->log[] = "Каталог <strong>templates</strong> создан успешно";
        }

        // создаём папку с активными шаблонами
        if (!is_dir(systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'act' . DIRECTORY_SEPARATOR . $module)) {
            if (is_writable(systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'act')) {
                mkdir(systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'act' . DIRECTORY_SEPARATOR . $module);
                $this->log[] = "Каталог для активных шаблонов создан";
            } else {
                $this->log[] = "Каталог для активных шаблонов не создан (нет доступа)";
            }
        }

        chdir($current_dir);

        return $this->log;
    }
}

?>