<?php
fileLoader::load('dataspace/iDataspace');

class arrayDataspace implements iDataspace
{
    protected $data;

    public function set($key, $value)
    {
        if(!is_scalar($key)) {
            // mzzInvalidParameter
        }

        $this->data[$key] = $value;
        return true;
    }

    public function get($key)
    {
        if(!is_scalar($key)) {
            // mzzInvalidParameter
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
            // mzzInvalidParameter
        }
        return isset($this->data[$key]);
    }
}
?>