<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * fileResolver: ������� ��������, �� �������� ����������� ��� ���������
 *
 * @package system
 * @subpackage resolver
 * @version 0.1.1
 */
class fileResolver implements iResolver
{
    /**
     * ������ ��������� (�������� ��� ������, ��� ������) ��� ������
     *
     * @var array
     */
    private $pattern = '';

    /**
     * �����������
     *
     * @param string $pattern ������� ��� ������
     */
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }


    /**
     * ������ �������� ������ ����� �� ���������
     *
     * @param string $request ��������� ������
     * @return string|null ���� �� �����, ���� ������ � null � ��������� ������
     */
    public function resolve($request)
    {
        $filename = str_replace('*', $request, $this->pattern);
        if (is_file($filename)) {
            return $filename;
        }
        return null;
    }
}

?>