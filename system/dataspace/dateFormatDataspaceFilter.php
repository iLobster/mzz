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

fileLoader::load('dataspace/dataspaceFilter');

/**
 * dateFormatDataspaceFilter: ������ ��� dataspace
 *
 * @package system
 * @version 0.1
 */
class dateFormatDataspaceFilter extends dataspaceFilter
{
    /**
     * ������ ����
     *
     * @var string
     */
    private $format;

    /**
     * �������
     *
     * @var array
     */
    private $keys;

    /**
     * �����������
     *
     * @param iDataspace $dataspace
     * @param array $keys
     * @param string $format ������ ����
     */
    public function __construct(iDataspace $dataspace, Array $keys, $format = 'd M Y / H:i:s')
    {
        // �������� �������� ����� �� �������� �� ������ ���������� $format
        // ��������� ������ �������� ����� ������� �� �������
        $this->format = $format;
        $this->keys = $keys;
        parent::__construct($dataspace);
    }

    /**
     * ���������� �������� �� �����
     *
     * @param string|intger $key ����
     * @return mixed
     */
    public function get($key)
    {
        // ����� ��� ��������� ��� ������������� ������ timestamp (is_int)
        // ��� ������������� ��� ������.. ���� ��

        // ��� ������ ���� �������� == 0?
        if(in_array($key, $this->keys) && $this->dataspace->get($key) != 0) {
            return date($this->format, $this->dataspace->get($key));
        } else {
            return $this->dataspace->get($key);
        }

    }
}

?>