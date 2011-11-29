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

    private $enabled = true;
    private static $globalDisabling = false;

    /**
     * Global disable|enable plugin in whole app (for more flexible memory management in large arrays of objects)
     */
    public static function globalDisable($disable = true)
    {
        self::$globalDisabling = $disable;
    }
    
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
        if (self::$globalDisabling) {
            return;
        }
        
        $key = $object->{$this->accessor}();
        $this->identityMap->set($key, $object);
    }

    public function preUpdate($object)
    {
        if (self::$globalDisabling) {
            return;
        }
        
        if ($object instanceof entity) {
            $this->enabled = false;
        }
    }

    public function postUpdate($object)
    {
        if (self::$globalDisabling) {
            return;
        }
        
        if (!$this->enabled) {
            $this->enabled = true;

            $this->postCreate($object);
        }
    }

    public function preSearchOneByField(& $data)
    {
        if (self::$globalDisabling) {
            return;
        }
        
        if ($this->enabled && $data[0] == $this->mapper->pk() && $object = $this->identityMap->get($data[1])) {
            $data = $object;
            return true;
        }
    }

    public function processRow(& $row)
    {
        if (self::$globalDisabling) {
            return;
        }
        
        $key = $row[$this->pk];
        if ($this->enabled && $this->identityMap->exists($key) && $object = $this->identityMap->get($key)) {
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