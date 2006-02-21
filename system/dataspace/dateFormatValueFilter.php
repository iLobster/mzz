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

fileLoader::load('dataspace/iValueFilter');

/**
 * dateFormatValueFilter: ������ ��� dataspace.
 * �������� unix timestamp � ����������� �������
 *
 * @package system
 * @version 0.1
 */
class dateFormatValueFilter implements iValueFilter
{
    /**
     * ������ ����
     *
     * @var string
     */
    private $format;

    /**
     * �����������
     *
     * @param string $format ������ ����
     */
    public function __construct($format = 'd M Y / H:i:s')
    {
        // �������� �������� ����� �� �������� �� ������ ���������� $format
        // ��������� ������ �������� ����� ������� �� �������
        $this->format = $format;
    }

    /**
     * ���������� �������� �� �����
     *
     * @param string|intger $key ����
     * @return mixed
     */
    public function filter($value)
    {
        // ����� ��� ��������� ��� ������������� ������ timestamp (is_int)
        // ��� ������������� ��� ������.. ���� ��

        return date($this->format, $value);
    }
}

?>