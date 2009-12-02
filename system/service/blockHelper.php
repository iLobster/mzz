<?php

class blockHelper
{
    protected $hidden = array();
    protected $content = array();
    protected static $instance = false;
    protected $weights = array();

    public function getInstance()
    {
        if (self::$instance == false) {
            self::$instance = new blockHelper();
        }
        return self::$instance;
    }

    public function hide($params)
    {
        $this->hidden[] = $params['name'];
    }

    public function isHidden($name)
    {
        if (is_array($name)) {
            $name = $name['name'];
        }
        return in_array($name, $this->hidden);
    }

    public function set($name, $position, $content, $weight = null)
    {
        if (strpos($position, ':')) {
            list($position, $weight) = explode(':', $position);
        }
        if ($weight === null) {
            $weight = 100;
        }

        if (!isset($this->content[$position])) {
            $this->content[$position] = array();
            $this->weights[$position] = array();
        }

        $this->content[$position][$name] = $content;
        $this->weights[$position][$name] = (int)$weight;
    }

    public function get($position)
    {
        if (is_array($position)) {
            $position = $position['position'];
        }
        if (!isset($this->content[$position])) {
            $this->content[$position] = array();
            $this->weights[$position] = array();
        }
        arsort($this->weights[$position]);

        $result = array();
        foreach ($this->weights[$position] as $name => $weight) {
            $result[$name] = $this->content[$position][$name];
        }
        return $result;
    }

    protected function __construct()
    {

    }
}

?>