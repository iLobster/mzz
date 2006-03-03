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
 * cachingResolver: ���������� ��������
 * ��������� ���������� ���� �������� � ����.
 * ��� ��������� ������� ����� ����� ���������
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */

final class cachingResolver extends decoratingResolver
{
    /**
     * ������ � ���������� ����
     *
     * @var array
     */
    private $cache;

    /**
     * ������ ��� ������ � ������, � ������� ������������ ���
     *
     * @var Fs
     */
    private $cache_file;

    /**
     * ����, ��������������� � true, ���� ��� ����� ��������
     *
     * @var bool
     */
    private $changed = false;

    /**
     * �����������
     *
     * @param object $resolver ��������, ������� ������������ ���������� ����������
     */
    public function __construct(iResolver $resolver)
    {
        // ����� ��� �����, � ������� ����� �������� ���
        $filename = systemConfig::$pathToTemp . 'resolver.cache';
        $mode = file_exists($filename) ? "r+" : "w";
        $this->cache_file = new SplFileObject($filename, $mode);
        // ���� ���� ���������� - ������ ��� ���������� � ������������� ��� � ������
        if ($mode == "r+") {
            while ($this->cache_file->eof() == false) {
                $this->cache .= $this->cache_file->fgets();
            }
            $this->cache = unserialize($this->cache);
        }

        parent::__construct($resolver);
    }

    /**
     * ��������� �������
     *
     * @param string $request ������ ������� (����/��� ������)
     * @return string|null ���� �� �������������� �����/������, ���� null ���� �� ������
     */
    public function resolve($request)
    {
        if (!isset($this->cache[$request])) {
            $this->changed = true;
            $this->cache[$request] = $this->resolver->resolve($request);
        }
        return $this->cache[$request];
    }

    /**
     * ����������
     * �� ����������� ������� ������ ���������� ���������� ���� � ����
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