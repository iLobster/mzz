<?php

class commentsMapper extends simpleMapper
{
    /**
     * ���������� �������� � �������� $fields ����� �������� � ��
     *
     * @param array $fields
     */
    protected function insertDataModify(&$fields)
    {
        $fields['time'] = time();
    }
}

?>