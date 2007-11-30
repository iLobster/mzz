<?php

class someMapper extends simpleMapper
{
    [...]

    protected function selectDataModify(&$modifyFields)
    {
        // в результате в SELECT запроса добавится REVERSE(`some`.`foo`) AS `foo`
        $modifyFields['foo'] = new sqlFunction('REVERSE', $this->className . '.foo', true);
    }
}

?>