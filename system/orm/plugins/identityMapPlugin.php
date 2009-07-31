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

    public function processRow(& $row)
    {
        $key = $row[$this->pk];
        if ($object = $this->identityMap->get($key)) {
            $row = $object;
            return true;
        }
    }
}

?>