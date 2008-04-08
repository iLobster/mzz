<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('i18n/i18nStorage');
fileLoader::load('service/iniFile');

/**
 * i18nStorageIni: класс для получения переводов из ini-файлов
 *
 * @package system
 * @subpackage i18n
 * @version 0.1.1
 */
class i18nStorageIni implements i18nStorage
{
    /**
     * Массив фраз
     *
     * @var array
     */
    private $data = array();

    private $lang;

    private $module;

    private $file;

    /**
     * Конструктор
     *
     * @param string $module имя модуля
     * @param string $lang язык
     */
    public function __construct($module, $lang)
    {
        $this->lang = $lang;
        $this->module = $module;

        $file = fileLoader::resolve($module . '/i18n/' . $lang . '.ini');
        $this->file = new iniFile($file);
        $this->data = $this->file->read();
        ksort($this->data);
    }

    /**
     * Получение фразы по идентификатору
     *
     * @param string $name
     */
    public function read($name)
    {
        if (!isset($this->data[$name])) {
            return $name;
        }

        if (isset($this->data[$name]['comment'])) {
            $comment = $this->data[$name]['comment'];
            unset($this->data[$name]['comment']);
        }

        if (sizeof($this->data[$name]) == 1) {
            $result = $this->data[$name][0];
        } else {
            $result = $this->data[$name];
        }

        if (isset($comment)) {
            $this->data[$name]['comment'] = $comment;
        }

        return $result;
    }

    public function exists($name)
    {
        return isset($this->data[$name]);
    }

    public function write($name, $value)
    {
        if (!$this->canWrite($name)) {
            return;
        }

        if (!is_array($value)) {
            $value = array($value);
        }

        if (isset($this->data[$name]['comment'])) {
            $comment = $this->data[$name]['comment'];
        }

        $this->data[$name] = $value;

        if (isset($comment)) {
            $this->data[$name]['comment'] = $comment;
        }
    }

    public function save()
    {
        $this->file->write($this->data);
    }

    private function canWrite($name)
    {
        if (isset($this->data[$name])) {
            return true;
        }

        if ($this->lang != systemConfig::$i18n) {
            $storage_default = new i18nStorageIni($this->module, systemConfig::$i18n);
            return $storage_default->exists($name);
        }

        return false;
    }

    public function getComment($name = null)
    {
        return isset($this->data[$name]['comment']) ? $this->data[$name]['comment'] : '';
    }

    public function setComment($name, $value)
    {
        if (isset($this->data[$name])) {
            $this->data[$name]['comment'] = $value;
        }
    }

    /**
     * Экспорт всех переменных
     *
     * @return array
     */
    public function export()
    {
        return $this->data;
    }
}