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
        // может тут как то сделать "кеширование" ? а то при запросе дважды ->getFolders() маппер будет опрошен тоже дважды.. появится трабла если папки будут изменены между первым и вторым запросом - но опять же, пока прецедента нет - может сделать кеширование?
        if (!$this->fields->exists('folders')) {
            $this->fields->set('folders', $this->mapper->getFolders($this->getId()));
        }
        return $this->fields->get('folders');
    }

    public function getItems()
    {
        if (!$this->fields->exists('items')) {
            $this->fields->set('items', $this->mapper->getItems($this->getId()));
        }
        return $this->fields->get('items');
    }

    private function setItems($items)
    {
        $this->fields->set('items', $items);
    }

    private function setFolders($folders)
    {
        $this->fields->set('folders', $folders);
    }
}

?>