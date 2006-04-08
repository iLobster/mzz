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
fileLoader::load('dataspace/dateFormatDataspaceFilter');
fileLoader::load('dataspace/dateFormatValueFilter');
fileLoader::load('dataspace/changeableDataspaceFilter');
// перенести!!
fileLoader::load('jip/jip');

class news
{
    protected $fields = array();
    protected $map;
    protected $filtered = false;

    public function __construct($map)
    {
        $this->map = $map;
        $this->fields = new arrayDataspace($this->fields);
    }

    public function __call($name, $args)
    {
        if (preg_match('/^(get|set)(\w+)/', strtolower($name), $match) && $attribute = $this->validateAttribute($name)) {
            if ('get' == $match[1]) {
                return $this->fields->get($attribute);
            } else {
                if ( ($this->isOnce($attribute) && $this->fields->exists($attribute) == false) || !$this->isOnce($attribute) ) {
                    $this->fields->set($attribute, $args[0]);
                }
            }
        } else {
            throw new Exception('Вызов неопределённого метода ' . __CLASS__ . '::' . $name . '()');
        }
    }

    protected function isOnce($attribute)
    {
        return isset($this->map[$attribute]['once']) && $this->map[$attribute]['once'];
    }

    private  function validateAttribute($name)
    {
        foreach ($this->map as $key => $val) {
            if (($val['accessor'] == $name) || ($val['mutator'] == $name)) {
                return $key;
            }
        }
    }

    public function getJip()
    {
        $toolkit = systemToolkit::getInstance();
        $action = $toolkit->getAction('news');

        $jip = new jip('news', 'news', $this->getId(), 'news', $action->getJipActions());

        return $jip->draw();
    }
}

?>