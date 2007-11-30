<?php

class simpleMapper
{
    [...]

    /**
     * Выполнение операций с массивом $fields перед обновлением в БД
     *
     * @param array $fields
     */
    protected function updateDataModify(&$fields)
    {
    }

    /**
     * Выполнение операций с массивом $fields перед вставкой в БД
     *
     * @param array $fields
     */
    protected function insertDataModify(&$fields)
    {
    }

    /**
     * Выполнение операций с массивом $fields после обновления в БД
     *
     * @param array $fields
     */
    protected function selectDataModify(&$fields)
    {
    }
}

?>