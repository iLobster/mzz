<?php
fileLoader::load('dataspace/iDataspace');

class arrayDataspace implements iDataspace
{
    protected $data;

    public function __construct($data)
    {
        $this->import($data);
    }

    public function set($key, $value)
    {
        if(!is_scalar($key)) {
            throw new mzzInvalidParameterException("Key is not scalar", $key);
        }

        $this->data[$key] = $value;
        return true;
    }

    public function get($key)
    {
        if(!is_scalar($key)) {
            throw new mzzInvalidParameterException("Key is not scalar", $key);
        }

        return ($this->exists($key)) ? $this->data[$key] : null;
    }

    public function delete($key)
    {
        unset($this->data[$key]);
        return true;
    }

    public function exists($key)
    {
        if(!is_scalar($key)) {
            throw new mzzInvalidParameterException("Key is not scalar", $key);
        }
        return isset($this->data[$key]);
    }

    public function import(Array $data)
    {
        $this->data = $data;
    }

    public function export()
    {
        return $this->data;
    }
}
?>