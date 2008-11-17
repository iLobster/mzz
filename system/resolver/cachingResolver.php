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
    /**
     * массив с содержимым кеша
     *
     * @var array
     */
    private $cache;

    /**
     * объект для работы с файлом, в который записывается кэщ
     *
     * @var Fs
     */
    private $cache_file;

    /**
     * флаг, устанавливается в true, если кеш нужно обновить
     *
     * @var bool
     */
    private $changed = false;

    /**
     * конструктор
     *
     * @param object $resolver резолвер, который декорируется кэширующим резолвером
     */
    public function __construct(iResolver $resolver, $cacheFile = 'resolver.cache')
    {
        // задаём имя файла, в котором будет хранится кэш
        $filename = systemConfig::$pathToTemp . '/' . $cacheFile;
        $mode = file_exists($filename) ? "r+" : "w";
        $this->cache_file = new SplFileObject($filename, $mode);
        // если файл существует - читаем его содержимое и десериализуем его в массив
        if ($mode == "r+") {
            while ($this->cache_file->eof() == false) {
                $this->cache .= $this->cache_file->fgets();
            }
            $this->cache = unserialize($this->cache);
        }

        parent::__construct($resolver);
    }

    /**
     * резолвинг запроса
     *
     * @param string $request строка запроса (файл/имя класса)
     * @return string|null путь до запрашиваемого файла/класса, либо null если не найден
     */
    public function resolve($request)
    {
        if (!isset($this->cache[$request])) {
            $this->changed = true;
            $fileName = $this->resolver->resolve($request);
            if (!empty($fileName)) {
                $this->cache[$request] = realpath($fileName);
            } else {
                return null;
            }
        }
        return $this->cache[$request];
    }

    /**
     * деструктор
     * по уничтожении объекта класса записывает содержимое кэша в файл
     *
     */
    public function __destruct()
    {
        if ($this->changed) {
            $this->cache_file->fseek(0);
            $serialized = serialize($this->cache);
            $this->cache_file->fwrite($serialized, strlen($serialized));
        }
        unset($this->cache_file);
    }
}

?>