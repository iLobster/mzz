<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * {{$mapper_data.mapper_name}}: маппер
 *
 * @package {{$mapper_data.module}}
 * @version 0.1
 */

class {{$mapper_data.mapper_name}} extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = '{{$mapper_data.module}}';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = '{{$mapper_data.doname}}';

    /**
     * Массив кешируемых методов
     *
     * @var array
     */
      protected $cacheable = array();

    /**
     * Конструктор
     *
     * @param string $section секция
     */
    public function __construct($section)
    {
        parent::__construct($section);
    }

    /**
     * Создает объект {{$mapper_data.doname}} из массива
     *
     * @param array $row
     * @return object
     */
    protected function createItemFromRow($row)
    {
        $map = $this->getMap();
        ${{$mapper_data.doname}}= new {{$mapper_data.doname}}($map);
        ${{$mapper_data.doname}}->import($row);
        return ${{$mapper_data.doname}};
    }

    /**
     * Создает пустой объект DO
     *
     * @return object
     */
    public function create()
    {
        return new {{$mapper_data.doname}}($this->getMap());
    }

    /**
     * Возвращает уникальный для ДО идентификатор исходя из аргументов запроса
     *
     * @return object
     */
    public function convertArgsToId($args)
    {

    }
}


?>