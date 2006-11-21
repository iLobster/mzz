<?php

class stubMapperForTree extends simpleMapper
{
    protected $name = 'simple';
    protected $className = 'stubSimpleForTree';

    /**
     * Конструктор
     *
     * @param string $section секция
     * @param string $alias название соединения с БД
     */
    public function __construct($section, $alias = 'default')
    {
        parent::__construct($section, $alias);
        $this->table = 'simple_stubsimple';
    }

    public function setTable($table)
    {        $this->table = $table;
    }



    public function convertArgsToId($args)
    {
    }
}

?>