<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * cache: класс для работы с кэшем
 *
 * @package system
 * @version 0.2.2
 */
class cache
{
    /**
     * Путь до кэш-директории
     *
     * @var string
     */
    private $cachePath;

    /**
     * Кэшируемый объект
     *
     * @var object
     */
    private $object;

    /**
     * "Состояние" кэшируемого объекта
     *
     * @var string
     */
    private $cond;

    /**
     * Конструктор
     *
     * @param iCacheable $object
     * @param string $cachePath путь до кэш-директории
     */
    public function __construct(iCacheable $object, $cachePath)
    {
        $this->object = $object;
        $this->cachePath = $cachePath;
        $this->object->injectCache($this);
    }

    /**
     * Call
     *
     * @param string $name
     * @param array $args
     * @return mixed
     */
    private function __call($name, $args = array())
    {
        return ($this->object->isCacheable($name)) ? $this->call($name, $args) : call_user_func_array(array($this->object, $name), $args);
    }

    /**
     * Вызов кэшируемого метода
     *
     * @param string $name
     * @param array $args
     * @return mixed
     */
    public function call($name, $args = array())
    {
        $cond = md5(serialize($this->object));
        if($cond != $this->cond) {
            $this->cond = $cond;
        }

        $path = $this->getPath();
        $filename = $cond . '_' . md5($name) . '_' . md5(serialize($args));

        $toolkit = systemToolkit::getInstance();
        /*
        $config = $toolkit->getConfig($this->object->section(), $this->object->name());
        $cacheEnabled = $config->get('cache');

        if(is_null($cacheEnabled)) {
            $config = $toolkit->getConfig('', 'common');
            $cacheEnabled = $config->get('cache');
        }
        */

        if (systemConfig::$cache && $this->isValid($filename)) {
            $result = $this->getCache($path, $filename);
        } else {
            //var_dump($name); echo '<br>';
            $result = call_user_func_array(array($this->object, $name), $args);
            if(systemConfig::$cache) {
                $this->writeCache($path, $filename, array($result, $this->object));
            }
        }

        return $result;
    }

    /**
     * Возвращает путь до кэш-директории
     *
     * @return string
     */
    private function getPath()
    {
        return $this->cachePath . '/' . $this->object->section() . '/' . $this->object->name() . '/';
    }

    /**
     * Проверяет путь $path на сущестование и если он не существует, то создает
     * его рекурсивно
     *
     * @param string $path путь
     */
    private function checkPath($path)
    {
        if(!is_dir($path)) {
            // Для правильной работы рекурсивного mkdir необходим путь с
            // правильным разделителем, который зависит от операционной системы
            if(DIRECTORY_SEPARATOR == '\\') {
                $path = str_replace('/', DIRECTORY_SEPARATOR, $path);
            }
            mkdir($path, 0777, true);
        }
    }

    /**
     * Устанавливает невалидность кэш-директории
     *
     * @param integer $period
     * @return boolean
     */
    public function setInvalid($period = 2)
    {
        return touch($this->getPath() . 'valid', time() + $period);
    }

    /**
     * Проверяет что кэш-файл с именем $filename валидный.
     * Кэш-файл считается валидным если он существует и
     * модифицирован позже, чем файл valid
     *
     * @param string $filename имя кэш-файла
     * @return boolean
     */
    private function isValid($filename)
    {
        $path = $this->getPath();
        if (!file_exists($path . 'valid')) {
            $this->checkPath($path);
            $this->setInvalid(0);
        }

        return file_exists($path . $filename) && filemtime($path . 'valid') <= filemtime($path . $filename);
    }

    /**
     * Получение кэша из файла
     *
     * @param string $path директория с кэш-файлами
     * @param string $filename имя кэш-файла
     * @return string
     */
    private function getCache($path, $filename)
    {
        $cache_file = new SplFileObject($path . $filename , "r");
        $cache_file->flock(LOCK_EX);
        $content = "";
        while ($cache_file->eof() == false) {
            $content .= $cache_file->fgets();
        }
        $cache_file->flock(LOCK_UN);
        unset($cache_file);

        $data = unserialize($content);

        $this->object = $data[1];

        return $data[0];
    }

    /**
     * Запись кэша в файл
     *
     * @param string $path директория с кэш-файлами
     * @param string $filename имя кэш-файла
     * @param string $data
     */
    private function writeCache($path, $filename, $data)
    {
        $cache_file = new SplFileObject($path . $filename , "w");
        $cache_file->flock(LOCK_EX);
        $cache_file->fwrite(serialize($data));
        $cache_file->flock(LOCK_UN);
        unset($cache_file);
    }
}

?>