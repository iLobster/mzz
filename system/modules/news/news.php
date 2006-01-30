<?php

class news
{
    private $id;
    private $title;
    private $text;
    private $folderid;

    public function __construct()
    {
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
}

?>