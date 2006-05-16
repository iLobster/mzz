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
 * simpleMapper: реализация общих методов у Mapper
 *
 * @package simple
 * @version 0.1
 */

abstract class simpleMapper
{
    protected $db;
    protected $table;
    protected $section;
    protected $name;

    /**
     * Постфикс для имени таблицы
     *
     * @var string
     */
    protected $tablePostfix = null;

    public function __construct($section)
    {
        $this->db = DB::factory();
        $this->section = $section;
        $this->table = $this->getName() . '_' .$this->getSection() . $this->tablePostfix;
    }

    protected function getName()
    {
        return $this->name;
    }

    protected function getSection()
    {
        return $this->section;
    }
}

?>