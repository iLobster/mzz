<?php
// класс работы с конфигурацией

class config
{
    protected $_ini;
    protected $_ini_file;

    public function __construct() {

    }

    public function load($file, $process_sections = true)
    {
        $file = CONFIG_DIR . $file . '.ini';
        if(!isset($this->_ini_file) || $this->_ini_file != $file) {
            if(($this->_ini = parse_ini_file($file, $process_sections)) !== false) {
                $this->_ini_file = $file;
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }

    }

    public function getOption($section, $name)
    {
        if(isset($this->_ini[$section][$name])) {
            return $this->_ini[$section][$name];
        } else {
            return false;
        }

    }
    public function getSection($section)
    {
        if(isset($this->_ini[$section])) {
            return $this->_ini[$section];
        } else {
            return false;
        }
    }
    public function update() {
        $file = $this->_ini_file;
        unset($this->_ini_file);
        $this->load($file);
    }

}



?>