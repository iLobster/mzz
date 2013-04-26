<?php

abstract class simpleSQLGenerator
{
    /**
     * Объект базы данных
     *
     * @var fPdo
     */
    protected $db;

    /**
     * Получение объекта для работы с БД
     *
     * @return fPdo
     */
    public function getDb()
    {
        if (!$this->db) {
            $this->db = fDB::factory();
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
        $type = gettype($value);

        if (is_null($value)) {
            return 'NULL';
        } elseif ($type == 'integer') {
            return $value;
        } elseif ($type == 'boolean') {
            return $value ? 'true' : 'false';
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

    public function valueToString($value)
    {
        if ($value instanceof sqlFunction || $value instanceof sqlOperator) {
            $value = $value->toString($this);
        } else {
            $value = $this->quote($value);
        }

        return $value;
    }
}
?>