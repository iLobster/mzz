<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

class simpleConfig
{

    protected $config = null;
    protected $fileName = null;

    protected $data = array();

    protected $loaded = false;
    protected $changed = false;
    
    public function  __construct($config)
    {
        $this->config = $config;
        $this->fileName = systemConfig::$pathToConf . DIRECTORY_SEPARATOR . $this->config . '.php';
    }

    public function __set($key, $val)
    {
        if(!$this->loaded) {
            $this->reload();
        }
        
        $this->data[$key] = $val;
        $this->changed = true;
    }

    public function __get($key)
    {
        if(!$this->loaded) {
            $this->reload();
        }

        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    public function __isset($key)
    {
        if(!$this->loaded) {
            $this->reload();
        }
        
        return isset($this->data[$key]);
    }

    public function __unset($key)
    {
        if(!$this->loaded) {
            $this->reload();
        }
        
        unset($this->data[$key]);
        $this->changed = true;
    }

    public function export()
    {
        if(!$this->loaded) {
            $this->reload();
        }
        
        return $this->data;
    }

    public function save()
    {
        if ($this->changed) {
            if ((is_file($this->fileName) && is_writable($this->fileName)) ||
                    (!file_exists($this->fileName) && is_writable(systemConfig::$pathToTemp))) {
                    file_put_contents($this->fileName, "<?php \n return " . var_export($this->data, true) . ";\n ?>");
                    $this->changed = false;
            } else {
                throw new mzzIoException($this->fileName);
            }
        }
    }

    public function reload()
    {
        if (file_exists($this->fileName)) {
            if (is_file($this->fileName) && is_readable($this->fileName)) {
                $this->data = include $this->fileName;
                if (!is_array($this->data)) {
                    $this->data = array();
                }
            } else {
                throw new mzzIoException($this->fileName);
            }
        }
    }
}
?>
