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
 * fileLoader: ����� ��� ��������/������ ������ �� �������
 *
 * @package system
 * @subpackage core
 * @version 0.1
 */

class fileLoader
{
    /**
     * ���� ����������
     *
     * @access private
     * @static
     * @var array
     */
    private static $stack = array();

    /**
     * ������� ��������
     *
     * @access private
     * @static
     * @var object
     */
    private static $resolver;

    /**
     * ������ ��� ����������� ������
     *
     * @var array
     */
    private static $files = array();

    /**
     * ��������� ������ ��������� � �������� ��������
     * ���������� ����������� � ����
     *
     * @access public
     * @param object $resolver
     */
    public static function setResolver($resolver)
    {
        array_push(self::$stack, self::$resolver);
        self::$resolver = $resolver;
    }

    /**
     * �������������� ���������� ��������� �� �����
     *
     * @access public
     */
    public function restoreResolver()
    {
        self::$resolver = array_pop(self::$stack);
    }

    /**
     * ��������� �������
     *
     * @access public
     * @static
     * @param string $request ������ ������� (����/��� ������)
     * @return string|null ���� �� �������������� �����/������, ���� null ���� �� ������
     */
    public static function resolve($request)
    {
        return self::$resolver->resolve($request);
    }

    /**
     * �������� �����
     *
     * @access public
     * @static
     * @param string $file ���� �� ������������� �����
     * @return boolean true - ���� ���� ��������; false - � ��������� ������
     */
    public static function load($file)
    {
        if (in_array($file, self::$files)) {
            return true;
        } else {
            if(!($filename = self::resolve($file))) {
                throw new mzzIoException($file);
            }
            //return false;
            self::$files[] = $file;
            require_once $filename;
            return true;
        }
    }
}

?>
