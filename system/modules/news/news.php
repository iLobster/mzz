<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

fileLoader::load('dataspace/arrayDataspace');

class news
{
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

    public function getJip() {

    }
}

?>