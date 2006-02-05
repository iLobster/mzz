<?php

class news
{
    /*private $id;
    private $title;
    private $text;
    private $folderid;*/
    protected $fields = array();
    protected $map;

    public function __construct($map)
    {
        $this->map = $map;
        $this->fields = new arrayDataspace($this->fields);
    }

    public function setId($id)
    {
        if ($this->fields->exists('id') == false) {
            //$this->id = $id;
            $this->fields->set('id', $id);
        }
    }

    public function __call($name, $args)
    {
        if (preg_match('/^(get|set)(\w+)/', strtolower($name), $match) && $attribute = $this->validateAttribute($match[2])) {
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
        print_r($this->map);
        if (isset($this->map[strtolower($name)])) {
            return $name;
        }
    }
}

?>