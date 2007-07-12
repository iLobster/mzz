<?php

class someMapper extends simpleMapper
{
    [...]

    protected function selectDataModify(&$modifyFields)
    {
        // � ���������� � SELECT ������� ��������� REVERSE(`some`.`foo`) AS `foo`
        $modifyFields['foo'] = new sqlFunction('REVERSE', $this->className . '.foo', true);
    }
}

?>