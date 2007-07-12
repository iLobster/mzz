<?php

class someMapper extends simpleMapper
{
    [...]

    protected function selectDataModify()
    {
        $modifyFields = array();

        $modifyFields['field_name'] = new sqlFunction('REVERSE', $this->className . '.foo', true);

        return $modifyFields;
    }
}

?>