<?php

abstract class simpleSQLGenerator
{
    /**
     * Объект базы данных
     *
     * @var mzzPdo
     */
    protected $db;

    /**
     * Получение объекта для работы с БД
     *
     * @return mzzPdo
     */
    public function getDb()
    {
        if (!$this->db) {
            $this->db = db::factory();
        }
        return $this->db;
    }

    /**
     * Экранирование значений
     *
     * @param mixed $value
     * @return mixed
     */
    public function quote($value)
    {
        if (is_null($value)) {
            return 'NULL';
        } elseif (is_numeric($value)) {
            return $value;
        }

        return $this->getDb()->quote($value);
    }

    /**
     * Экранирование алиасов
     *
     * @param string $alias
     * @return string
     */
    public function quoteAlias($alias)
    {
        return '`' . $alias . '`';
    }

    /**
     * Экранирование имён полей
     *
     * @param string $field
     * @return string
     */
    public function quoteField($field)
    {
        return '`' . str_replace('.', '`.`', $field) . '`';
    }

    /**
     * Экранирование имён таблиц
     *
     * @param string $table
     * @return string
     */
    public function quoteTable($table)
    {
        return '`' . $table . '`';
    }

    public function __sleep()
    {
        return array();
    }

    public function __wakeup()
    {
        $this->getDb();
    }

}
?>