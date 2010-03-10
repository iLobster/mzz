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

    /**
     * Constructor of class
     * 
     * @param string $config file name
     */
    public function  __construct($config)
    {
        $this->config = $config;
        $this->fileName = systemConfig::$pathToConf . DIRECTORY_SEPARATOR . $this->config . '.php';
    }

    /**
     *  Sets value for key
     *
     * @param string|integer $key
     * @param mixed $val
     */
    public function set($key, $val)
    {
        if (!is_scalar($key)) {
            throw new mzzInvalidParameterException("Key is not scalar", $key);
        }

        if(!$this->loaded) {
            $this->reload();
        }
        
        $this->data[$key] = $val;
        $this->changed = true;
    }

    /**
     * Return value for a key or default value
     *
     * @param string|integer $key
     * @param mixed $default value if key does not exists
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (!is_scalar($key)) {
            throw new mzzInvalidParameterException("Key is not scalar", $key);
        }

        if(!$this->loaded) {
            $this->reload();
        }

        return isset($this->data[$key]) ? $this->data[$key] : $default;
    }

    /**
     * Checks whether key exists
     *
     * @param string|integer $key
     * @return boolean
     */
    public function exists($key)
    {
        if (!is_scalar($key)) {
            throw new mzzInvalidParameterException("Key is not scalar", $key);
        }

        if(!$this->loaded) {
            $this->reload();
        }
        
        return isset($this->data[$key]);
    }

    /**
     * Unset the key
     *
     * @param string|integer $key
     */
    public function delete($key)
    {
        if (!is_scalar($key)) {
            throw new mzzInvalidParameterException("Key is not scalar", $key);
        }

        if(!$this->loaded) {
            $this->reload();
        }
        
        unset($this->data[$key]);
        $this->changed = true;
    }

    /**
     * Import array of values
     *
     * @param array $data to import
     * @param boolean $merge to merge exists data with new one
     */
    public function import(array $data, $merge = false)
    {
        if(!$this->loaded) {
            $this->reload();
        }
        
        $this->data = ($merge) ? array_merge($this->data, $data) : $data;
    }

    /**
     * Returns config data
     *
     * @return array
     */
    public function export()
    {
        if(!$this->loaded) {
            $this->reload();
        }
        
        return $this->data;
    }

    /**
     * Saves config file
     */
    public function save()
    {
        if ($this->changed) {
            if ((is_file($this->fileName) && is_writable($this->fileName)) ||
                    (!file_exists($this->fileName) && is_writable(systemConfig::$pathToTemp))) {
                    file_put_contents($this->fileName, "<?php \n return " . var_export($this->data, true) . ";\n ?>");
                    $this->changed = false;
                    return true;
            } else {
                throw new mzzIoException($this->fileName);
            }
        }
    }

    /**
     * Reloads config file
     */
    public function reload()
    {
        if (file_exists($this->fileName)) {
            if (is_file($this->fileName) && is_readable($this->fileName)) {
                $this->data = include $this->fileName;
                if (!is_array($this->data)) {
                    $this->data = array();
                }

                $this->loaded = true;
                $this->changed = false;
                return true;
            }

            throw new mzzIoException($this->fileName);
        }
    }

    /**
     * Whether config changed
     *
     * @return boolean
     */
    public function isChanged()
    {
        return (bool) $this->changed;
    }
}
?>
