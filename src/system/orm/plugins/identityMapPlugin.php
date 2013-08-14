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
     * @param bool [$disable]
     */
    public static function globalDisable($disable = true)
    {
        self::$globalDisabling = $disable;
    }
    
    /**
     * Removes all cached data
     */
    public static function globalFlush()
    {
        // Flush all identity maps for all mappers
        foreach (systemToolkit::getInstance()->getMapperStack() as $mapper) {
            if ($mapper->isAttached('identityMap')) {
                $mapper->plugin('identityMap')->flush();
            }
        }
        
        // Call GC collect cycle
        if (function_exists('gc_collect_cycles')) {
            gc_collect_cycles();
        }
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
    
    /**
     * Flush all saved data
     */
    public function flush()
    {
        if ($this->identityMap) {
            $this->identityMap->flush();
        }
    }
}

?>