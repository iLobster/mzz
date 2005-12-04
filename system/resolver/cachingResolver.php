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
 * cachingResolver: кэширующий резолвер
 * сохраняет результаты всех запросов в файл.
 * при повторном запросе сразу выдаёт результат
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */

final class cachingResolver extends decoratingResolver
{
    /**#@+
    * @access private
    */
    /**
     * массив с содержимым кеша
     *
     * @var array
     */
    private $cache = array();

    /**
     * объект для работы с файлом, в который записывается кэщ
     *
     * @var Fs
     */
    private $cache_file;

    /**#@-*/

    /**
     * конструктор
     *
     * @access public
     * @param object $resolver резолвер, который декорируется кэширующим резолвером
     */
    public function __construct($resolver)
    {
        // задаём имя файла, в котором будет хранится кэш
        $filename = systemConfig::$pathToTemp . 'resolver.cache';
        // если файл существует - читаем его содержимое и десериализуем его в массив
        if (file_exists($filename)) {
            $this->cache = unserialize(file_get_contents($filename));
        }
        // path for php 5.1.0
        if(class_exists('SplFileObject')) {
            $this->cache_file = new SplFileObject($filename, 'w');
        } else {
            $this->cache_file = new Fs($filename, 'w');
        }
        parent::__construct($resolver);
    }

    /**
     * резолвинг запроса
     *
     * @access public
     * @param string $request строка запроса (файл/имя класса)
     * @return string|null путь до запрашиваемого файла/класса, либо null если не найден
     */
    public function resolve($request)
    {
        if (!isset($this->cache[$request])) {
            $this->cache[$request] = $this->resolver->resolve($request);
        }
        return $this->cache[$request];
    }

    /**
     * деструктор
     * по уничтожении класса записываем содержимое кэша в файл
     *
     * @access public
     */
    public function __destruct()
    {
        $this->cache_file->fwrite(serialize($this->cache));
    }

}
?>