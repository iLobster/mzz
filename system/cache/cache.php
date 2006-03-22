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
    private $cacheResult = array();

    public function __construct($cache_path)
    {
        $this->cachePath = $cache_path;
    }

    public function get($id)
    {
        if($this->isCached($id) == true) {
            if(isset($this->cacheResult[$id])) {
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
        foreach(new mzzCacheFilterIterator(new DirectoryIterator($this->cachePath)) as $iterator) {
            unlink($iterator->getPath() . DIRECTORY_SEPARATOR . $iterator->getFilename());
        }
    }
}

?>