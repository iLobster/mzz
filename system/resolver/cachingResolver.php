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
    private $cache = array();

    /**
     * ������ ��� ������ � ������, � ������� ������������ ���
     *
     * @var Fs
     */
    private $cache_file;


    /**
     * �����������
     *
     * @param object $resolver ��������, ������� ������������ ���������� ����������
     */
    public function __construct(iResolver $resolver)
    {
        // ����� ��� �����, � ������� ����� �������� ���
        $filename = systemConfig::$pathToTemp . 'resolver.cache';
        // ���� ���� ���������� - ������ ��� ���������� � ������������� ��� � ������
        if (file_exists($filename)) {
            $this->cache = unserialize(file_get_contents($filename));
        }

        $this->cache_file = new SplFileObject($filename, 'w');
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
        $this->cache_file->fwrite(serialize($this->cache));
    }

}
?>