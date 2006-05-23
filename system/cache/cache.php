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
 * cache: ����� ��� ������ � �����
 *
 * @package system
 * @version 0.2.1
 */
class cache
{
    /**
     * ���� �� ���-����������
     *
     * @var string
     */
    private $cachePath;

    /**
     * ���������� ������
     *
     * @var object
     */
    private $object;

    /**
     * �����������
     *
     * @param iCacheable $object
     * @param string $cachePath ���� �� ���-����������
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
     * ����� ����������� ������
     *
     * @param string $name
     * @param array $args
     * @return mixed
     */
    public function call($name, $args = array())
    {
        $path = $this->getPath();
        $filename = md5($name) . '_' . md5(serialize($args));

        $toolkit = systemToolkit::getInstance();
        $config = $toolkit->getConfig();
        $config->load('common');
        $cacheEnabled = $config->getOption('cache', 'cache');

        if ($cacheEnabled && $this->isValid($filename)) {
            $result = $this->getCache($path, $filename);
        } else {
            $result = call_user_func_array(array($this->object, $name), $args);
            if($cacheEnabled) {
                $this->checkPath($path);
                $this->writeCache($path, $filename, $result);
            }
        }

        return $result;
    }

    /**
     * ���������� ���� �� ���-����������
     *
     * @return string
     */
    private function getPath()
    {
        return $this->cachePath . '/' . $this->object->section() . '/' . $this->object->name() . '/';
    }

    /**
     * ��������� ���� $path �� ������������ � ���� �� �� ����������, �� �������
     * ��� ����������
     *
     * @param string $path ����
     */
    private function checkPath($path)
    {
        if(!is_dir($path)) {
            // ��� ���������� ������ ������������ mkdir ��������� ���� �
            // ���������� ������������, ������� ������� �� ������������ �������
            if(DIRECTORY_SEPARATOR == '\\') {
                $path = str_replace('/', DIRECTORY_SEPARATOR, $path);
            }
            mkdir($path, 0777, true);
        }
    }

    /**
     * ������������� ������������ ���-����������
     *
     * @param integer $period
     * @return boolean
     */
    public function setInvalid($period = 2)
    {
        return is_dir($this->getPath()) && touch($this->getPath() . 'valid', time() + $period);
    }

    /**
     * ��������� ��� ���-���� � ������ $filename ��������.
     * ���-���� ��������� �������� ���� �� ���������� �
     * ������������� �����, ��� ���� valid
     *
     * @param string $filename ��� ���-�����
     * @return boolean
     */
    private function isValid($filename)
    {
        $path = $this->getPath();
        if (!file_exists($path . 'valid')) {
            $this->setInvalid(0);
        }

        return file_exists($path . $filename) && filemtime($path . 'valid') <= filemtime($path . $filename);
    }

    /**
     * ��������� ���� �� �����
     *
     * @param string $path ���������� � ���-�������
     * @param string $filename ��� ���-�����
     * @return unknown
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

        return unserialize($content);
    }

    /**
     * ������ ���� � ����
     *
     * @param string $path ���������� � ���-�������
     * @param string $filename ��� ���-�����
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