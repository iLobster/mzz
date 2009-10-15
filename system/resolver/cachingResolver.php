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

require_once systemConfig::$pathToSystem . '/cache/cache.php';
require_once systemConfig::$pathToSystem . '/cache/cacheFile.php';

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
    private $cache = array();

    /**
     * @var cache
     */
    private $cacheBackend;

    private $cacheName;

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
    public function __construct(iResolver $resolver, $cacheName = 'resolver_cache')
    {
        $this->cacheName = $cacheName;

        $this->cacheBackend = cache::factory('long');

        $this->cache = $this->cacheBackend->get($cacheName);

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
            $this->cacheBackend->set($this->cacheName, $this->cache);
        }
    }
}

?>