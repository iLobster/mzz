<?php

class newsFolder
{
    private $id;
    private $name;
    private $parent;
    private $mapper;
    private $folders;
    private $items;

    public function __construct($mapper)
    {
        $this->mapper = $mapper;
    }

    public function setId($id)
    {
        if (empty($this->id)) {
            $this->id = $id;
        }
    }

    public function __call($name, $args)
    {
        if (preg_match('/^(get|set)(\w+)/', strtolower($name), $match) && $attribute = $this->validateAttribute($match[2])) {
            if ('get' == $match[1]) {
                return $this->$attribute;
            } else {
                $this->$attribute = $args[0];
            }
        } else {
            throw new Exception('Вызов неопределённого метода ' . __CLASS__ . '::' . $name . '()');
        }
    }

    private  function validateAttribute($name)
    {
        $name = strtolower($name);
        if (in_array($name, array_keys(get_class_vars(__CLASS__)))) {
            return $name;
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