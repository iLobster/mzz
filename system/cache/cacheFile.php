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
 * @package system
 * @subpackage cache
 * @version $Id$
 */

/**
 * cacheFile: драйвер кэширования в файлы
 *
 * @package system
 * @subpackage cache
 * @version 0.0.1
 */

class cacheFile extends cache
{
    /**
     * Путь до каталога, где будут храниться файлы кэша
     *
     * @var string
     */
    protected $path;

    /**
     * Префикс файла кэша.
     *
     * @var string
     */
    protected $prefix;

    private $expire = 60;

    /**
     * Конструктор
     *
     */
    public function __construct(Array $params)
    {
        if (!isset($params['path']) || !is_dir($params['path'])) {
            throw new mzzRuntimeException('A valid cache directory must be specified for cacheFile');
        }

        $this->path = $params['path'];
        $this->prefix = isset($params['prefix']) ? $params['prefix'] : 'cf_';

        if (isset($params['expire'])) {
            $this->expire = $params['expire'];
        }
    }

    public function set($key, $value, array $tags = array(), $expire = null)
    {
        if (is_null($expire)) {
            $expire = $this->expire;
        }

        $cacheFile = $this->getPattern(md5($key), $expire);

        $data = $this->setTags($value, $tags);

        if (is_object($value)) {
            $data['data'] = 'mark';
        }

        $data_str = var_export($data, true);

        if (is_object($value)) {
            $data_str = str_replace("'data' => 'mark'", "'data' => unserialize('" . str_replace("'", "\'", serialize($value)) . "')", $data_str);
        }

        file_put_contents($cacheFile, "<?php\r\nreturn " . $data_str . ';');

        return true;
    }

    public function get($key)
    {
        $file = $this->getFile($key);
        if ($file) {
            $expire = $this->extractExpire(basename($file));

            if (is_file($file) && ((filemtime($file) + $expire) > time())) {
                $data = require $file;

                $this->checkTags($data, $key);

                return $data['data'];
            }
        }
    }

    public function delete($key, $params = array())
    {
        $file = $this->getFile($key);
        if ($file && is_file($file)) {
            unlink($file);
            return true;
        }

        return false;
    }

    public function flush($params = array())
    {
        $files = $this->getFilesByPattern($this->getPattern('*', '*'));

        if (is_array($files)) {
            $this->deleteFiles($files);
        }

        return true;
    }

    protected function getPattern($key, $expire)
    {
        $name = $this->prefix . $key . '_' . $expire . '.cache';
        return $this->path . DIRECTORY_SEPARATOR . $name;
    }

    protected function getFile($key)
    {
        $files = $this->getFilesByPattern($this->getPattern(md5($key), '*'));

        if (is_array($files)) {
            $file = array_shift($files);

            if ($file) {
                $this->deleteFiles($files);
                return $file;
            }
        }

        return false;
    }

    protected function getFilesByPattern($pattern)
    {
        $files = glob($pattern);
        return $files;
    }

    protected function deleteFiles(Array $files)
    {
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    protected function extractExpire($filename)
    {
        $expire = 0;
        if (preg_match('!^' . $this->prefix . '.*_(\d+).cache$!', $filename, $match)) {
            $expire = $match[1];
        }

        return $expire;
    }
}

?>