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
     * @var array
     */
    private static $stack = array();

    /**
     * ������� ��������
     *
     * @var object
     */
    private static $resolver;
public static $time;
public static $re;
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
     * @param object $resolver
     */
    public static function setResolver(iResolver $resolver)
    {
        array_push(self::$stack, self::$resolver);
        self::$resolver = $resolver;
    }

    /**
     * �������������� ���������� ��������� �� �����
     *
     */
    public function restoreResolver()
    {
        self::$resolver = array_pop(self::$stack);
    }

    /**
     * ��������� �������
     *
     * @param string $request ������ ������� (����/��� ������)
     * @return string|null ���� �� �������������� �����/������, ���� null ���� �� ������
     */
    public static function resolve($request)
    { 
$abc = microtime(1); self::$resolver->resolve($request);
        self::$time[] = number_format(microtime(1) - $abc, 8);

        if (!($filename = self::$resolver->resolve($request))) {

            throw new mzzIoException($request);
        }
self::$re[] = $request;;
        return $filename;
    }

    /**
     * �������� �����
     *
     * @param string $file ���� �� ������������� �����
     * @return boolean true - ���� ���� ��������; false - � ��������� ������
     */
    public static function load($file)
    {
        if (!isset(self::$files[$file])) {
            $filename = self::resolve($file);
            self::$files[$file] = 1;
            require_once $filename;
        }
        return true;
    }
}

?>
