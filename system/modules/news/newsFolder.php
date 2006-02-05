<?php

class newsFolder
{
    protected $fields = array();
    protected $map;
    private $mapper;
    private $folders;
    private $items;

    public function __construct($mapper, $map)
    {
        $this->mapper = $mapper;
        $this->map = $map;
        $this->fields = new arrayDataspace($this->fields);
    }

    public function setId($id)
    {
        if ($this->fields->exists('id') == false) {
            $this->fields->set('id', $id);
        }
    }

    public function __call($name, $args)
    {
        if (preg_match('/^(get|set)(\w+)/', strtolower($name), $match) && $attribute = $this->validateAttribute($name)) {
            if ('get' == $match[1]) {
                return $this->fields->get($attribute);
            } else {
                $this->fields->set($attribute, $args[0]);
            }
        } else {
            throw new Exception('Вызов неопределённого метода ' . __CLASS__ . '::' . $name . '()');
        }
    }

    private  function validateAttribute($name)
    {
        foreach ($this->map as $key => $val) {
            if (($val['accessor'] == $name) || ($val['mutator'] == $name)) {
                return $key;
            }
        }
    }

    public function getFolders()
    {
        $this->mapper->getFolders($this);
        return $this->folders;
    }

    public function getItems()
    {
        $this->mapper->getItems($this);
        return $this->items;
    }

    public function setItems($items)
    {
        $this->items = $items;
    }

    public function setFolders($folders)
    {
        $this->folders = $folders;
    }
}

?>