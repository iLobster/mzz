<?php

fileLoader::load('dataspace/dataspaceFilter');

class dateFormatDataspaceFilter extends dataspaceFilter
{
    private $format;
    private $keys;

    public function __construct($dataspace, $keys, $format = 'd M Y / H:i:s')
    {
        // �������� �������� ����� �� �������� �� ������ ���������� $format
        // ��������� ������ �������� ����� ������� �� �������
        $this->format = $format;
        $this->keys = $keys;
        parent::__construct($dataspace);
    }

    public function get($key)
    {
        // ����� ��� ��������� ��� ������������� ������ timestamp (is_int)
        // ��� ������������� ��� ������.. ���� ��
        return (in_array($key, $this->keys)) ? date($this->format, $this->dataspace->get($key)) : $this->dataspace->get($key);
    }
}

?>