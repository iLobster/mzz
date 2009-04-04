<?php

class observer
{
    protected $mapper;

    protected $options = array();

    public function __construct($options = array())
    {
        $this->options = array_merge($this->options, $options);
    }

    protected function updateMap(array & $map)
    {
    }

    public function setMapper(mapper $mapper)
    {
        $this->mapper = $mapper;
        $map = $this->mapper->map();
        $this->updateMap($map);
        $this->mapper->map($map);
    }

    public function preInsert(array & $data)
    {
    }

    public function preSqlInsert(criteria $criteria)
    {
    }

    public function postSqlInsert(entity $object)
    {
    }

    public function preSqlJoin(array & $data)
    {
    }

    public function postInsert(entity $object)
    {
    }

    public function preUpdate(& $data)
    {
    }

    public function preSqlUpdate(criteria $criteria)
    {
    }

    public function postUpdate(entity $object)
    {
    }

    public function preDelete(entity $object)
    {
    }

    public function preSqlDelete(criteria $criteria)
    {
    }

    public function postDelete(entity $object)
    {
    }

    public function preSelect(criteria $criteria)
    {
    }

    public function preCreate(entity $object)
    {
    }

    public function postCreate(entity $object)
    {
    }

    public function preSqlSelect(criteria $criteria)
    {
    }

    public function processRow(& $row)
    {
    }

    public function postCollectionSelect(collection $collection)
    {
    }

    public function getName()
    {
        return preg_replace('!Plugin$!', '', get_class($this));
    }
}

?>