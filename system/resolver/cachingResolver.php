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
    /**#@+
    * @access private
    */
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

    /**#@-*/

    /**
     * �����������
     *
     * @access public
     * @param object $resolver ��������, ������� ������������ ���������� ����������
     */
    public function __construct($resolver)
    {
        // ����� ��� �����, � ������� ����� �������� ���
        $filename = TEMP_DIR . 'resolver.cache';
        // ���� ���� ���������� - ������ ��� ���������� � ������������� ��� � ������
        if (file_exists($filename)) {
            $this->cache = unserialize(file_get_contents($filename));
        }
        $this->cache_file = new Fs($filename, 'w');
        parent::__construct($resolver);
    }

    /**
     * ��������� �������
     *
     * @access public
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
     * �� ����������� ������ ���������� ���������� ���� � ����
     *
     * @access public
     */
    public function __destruct()
    {
        $this->cache_file->write(serialize($this->cache));
    }

}
?>