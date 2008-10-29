<?php

class sideHelper
{
    protected $hidden = array();
    protected $content = array();
    protected static $instance = false;
    protected $weights = array();

    public function getInstance()
    {
        if (self::$instance == false) {
            self::$instance = new sideHelper();
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

    public function set($align, $name, $content, $weight = null)
    {
        if ($weight === null) {
            $weight = 100;
        }

        if (!isset($this->content[$align])) {
            $this->content[$align] = array();
            $this->weights[$align] = array();
        }

        $this->content[$align][$name] = $content;
        $this->weights[$align][$name] = (int)$weight;
    }

    public function get($align)
    {
        if (is_array($align)) {
            $align = $align['side'];
        }
        if (!isset($this->content[$align])) {
            $this->content[$align] = array();
            $this->weights[$align] = array();
        }
        arsort($this->weights[$align]);

        $result = array();
        foreach ($this->weights[$align] as $name => $weight) {
        	$result[$name] = $this->content[$align][$name];
        }

        return $result;
    }

    protected function __construct()
    {

    }
}

?>