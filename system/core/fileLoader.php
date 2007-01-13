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
 * @subpackage core
 * @version $Id$
*/

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
        if (!($filename = self::$resolver->resolve($request))) {
            throw new mzzIoException($request);
        }
        return $filename;
    }

    /**
     * �������� �����
     *
     * @param string $file ��� ��� ������������� �����. ���������� ���� ����� ������������� ��������� � ������� Resolver-��
     * @return boolean true - ���� ���� ��� ��� ��������
     */
    public static function load($file)
    {
        if (!isset(self::$files[$file])) {
            $filename = self::resolve($file);
            self::$files[$file] = 1;
            // require_once �� ������������ ��-�� �� �����������
            require $filename;
        }
        return true;
    }
}
?>