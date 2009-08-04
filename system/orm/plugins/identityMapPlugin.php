<?php

fileLoader::load('orm/identityMap');

class identityMapPlugin extends observer
{
    /**
     * @var identityMap
     */
    private $identityMap;

    private $accessor;
    private $pk;

    public function setMapper(mapper $mapper)
    {
        parent::setMapper($mapper);

        $map = $mapper->map();

        $this->accessor = $map[$mapper->pk()]['accessor'];
        $this->pk = $mapper->pk();

        $this->identityMap = new identityMap($mapper);
    }

    public function postCreate($object)
    {
        $key = $object->{$this->accessor}();

        $this->identityMap->set($key, $object);
    }

    public function preSearchOneByField(& $data)
    {
        if ($data[0] == $this->mapper->pk() && $object = $this->identityMap->get($data[1])) {
            $data = $object;
            return true;
        }
    }

    public function processRow(& $row)
    {
        $key = $row[$this->pk];
        if ($this->identityMap->exists($key) && $object = $this->identityMap->get($key)) {
            $row = $object;
            return true;
        }
    }

    public function delay($key, $value)
    {
        if ($this->mapper->pk() == $key) {
            $this->identityMap->delay($value);
        }
    }
}

?>