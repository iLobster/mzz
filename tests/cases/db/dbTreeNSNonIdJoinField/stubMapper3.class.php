<?php
class stubMapperForTreeNonIdTest extends simpleMapper
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
        $this->table = 'simple_stubSimple3';
    }
    
    /**
     * Заполняет данными из массива доменный объект
     *
     * @param array $row массив с данными
     * @return object
     */
    public function createItemFromRow($row)
    {
        $object = $this->create();
        $object->import($row);
        return $object;
    }    


    public function convertArgsToId($args)
    {
    }
}
?>