<?php

class commentsMapper extends simpleMapper
{
    /**
     * Выполнение операций с массивом $fields перед вставкой в БД
     *
     * @param array $fields
     */
    protected function insertDataModify(&$fields)
    {
        $fields['time'] = time();
    }
}

?>