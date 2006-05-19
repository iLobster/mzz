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
 * @version 0.1
 * @deprecated Скорее всего этот класс будет полностью переписан
*/
fileLoader::load('iterators/mzzCacheFilterIterator');

class cache
{
    private $cachePath;
    private $object;

    public function __construct($object, $cachePath)
    {
        $this->object = $object;
        $this->cachePath = $cachePath;
    }

    public function __call($name, $args = array())
    {
        // проверяем что метод нужно кешировать
        if (true) {
            return $this->call($name, $args);
        } else {
            return call_user_func_array(array($this->object, $name), $args);
        }
    }

    public function call($name, $args = array())
    {
        // тут нужно создавать целый путь если он не существует. (подробнее, чем плох текущий вариант)
        // возможно классом fs который давно давно удалили

        $path = $this->getPath();
        $filename = md5($name) . '_' . md5(serialize($args));

        if ($this->isValid($filename)) {
            $result = $this->getCache($path, $filename);
        } else {
            $result = call_user_func_array(array($this->object, $name), $args);
            $this->writeCache($path, $filename, $result);
        }

        return $result;
    }

    private function getPath()
    {
        return $this->cachePath . '/' . $this->object->getSection() . '/' . $this->object->getName() . '/';
    }

    public function setInvalid($period = 2)
    {
        return touch($this->getPath() . 'valid', time() + $period);
    }

    private function isValid($filename)
    {
        // тут тоже юзать SPL ?
        // всмысле?
        $path = $this->getPath();
        if (!file_exists($path . 'valid')) {
            $this->setInvalid(0);
        }

        return (file_exists($path . $filename)) ? filemtime($path . 'valid') <= filemtime($path . $filename) : false;
    }

    private function getCache($path, $filename)
    {
        // проверять что файл существует, кидать эксепшн
        // экспшен бросает SplFileObject
        $cache_file = new SplFileObject($path . $filename , "r");

        $cache_file->flock(LOCK_EX);

        $content = "";

        while ($cache_file->eof() == false) {
            $content .= $cache_file->fgets();
        }

        $cache_file->flock(LOCK_UN);

        unset($cache_file);

        return unserialize($content);
    }

    private function writeCache($path, $filename, $data)
    {
        $cache_file = new SplFileObject($path . $filename , "w");
        $cache_file->flock(LOCK_EX);
        $cache_file->fwrite(serialize($data));
        $cache_file->flock(LOCK_UN);
        unset($cache_file);
    }
}

/*
class cache
{
private $cachePath;
private $cacheResult = array();

public function __construct($cache_path)
{
$this->cachePath = $cache_path . '/';
}

public function get($id)
{
if ($this->isCached($id) == true) {
if (isset($this->cacheResult[$id])) {
return $this->cacheResult[$id];
} else {
$cache_file = new SplFileObject($this->getCacheFile($id), "r");
$cache_file->flock(LOCK_EX);
$content = "";
while ($cache_file->eof() == false) {
$content .= $cache_file->fgets();
}
$cache_file->flock(LOCK_UN);
$this->cacheResult[$id] = unserialize($content);
return $this->cacheResult[$id];
}
} else {
throw new mzzRuntimeException("Cache for '" . $id . "' expired!");
}
}

public function save($result, $id)
{
$cache_file = new SplFileObject($this->getCacheFile($id), "w");
$cache_file->flock(LOCK_EX);
$cache_file->fwrite(serialize($result));
$cache_file->flock(LOCK_UN);
}

public function isCached($id)
{
if (file_exists($this->getCacheFile($id))) {
return filemtime($id) <= filemtime($this->getCacheFile($id));
}
return false;
}

private function getCacheFile($id)
{
return $this->cachePath .  'cache_' . $this->hash($id);
}

private function hash($id)
{
return sprintf("%u", crc32($id));
}

public function clearCache()
{
foreach (new mzzCacheFilterIterator(new DirectoryIterator($this->cachePath)) as $iterator) {
unlink($iterator->getPath() . DIRECTORY_SEPARATOR . $iterator->getFilename());
}
}
} */

?>