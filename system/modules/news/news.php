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
        //$this->enableDataspaceFilter();
    }

    public function setId($id)
    {
        if ($this->fields->exists('id') == false) {
            $this->fields->set('id', $id);
        }
    }

    public function setCreated($created)
    {
        if ($this->fields->exists('created') == false) {
            $this->fields->set('created', $created);
        }
    }

    public function setUpdated($updated)
    {
        if ($this->fields->exists('updated') == false) {
            $this->fields->set('updated', $updated);
        }
    }

    public function getCreated()
    {
        /*$created = $this->fields->get('created');
        if (empty($created)) {
            $this->fields->set('created', time());
        }*/
        return $this->fields->get('created');
    }

    public function getUpdated()
    {
        /*$updated = $this->fields->get('updated');
        if (empty($updated)) {
            $this->fields->set('updated', time());
        }*/
        return $this->fields->get('updated');
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
        $toolkit = systemToolkit::getInstance();
        $action = $toolkit->getAction('news');

        $jip = new jip('news', 'news', $this->getId(), 'news', $action->getJipActions());

        return $jip->draw();
    }

    /**
     * @deprecated moved in view?
    public function enableDataspaceFilter()
    {
        if($this->filtered == false) {
            $dateFilter = new dateFormatValueFilter();
            $this->fields = new changeableDataspaceFilter($this->fields);
            $this->fields->addReadFilter('created', $dateFilter);
            $this->fields->addReadFilter('updated', $dateFilter);
            $this->filtered = true;
        }
    }

    public function disableDataspaceFilter()
    {
        if($this->filtered == true) {
            $this->fields = new arrayDataspace($this->fields->export());
            $this->filtered = false;
        }
    }
    */
}

?>