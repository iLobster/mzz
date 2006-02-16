<?php

class dataspaceFilter implements iDataspace
{
    protected  $dataspace;

    public function __construct(iDataspace $dataspace)
    {
        $this->dataspace = $dataspace;
    }

    public function set($key, $value)
    {
        if(!is_scalar($key)) {
            throw new mzzInvalidParameterException("Key is not scalar", $key);
        }

        $this->dataspace->set($key, $value);
        return true;
    }

    /**
     * Возвращает значение по ключу
     *
     * @param string|intger $key ключ
     * @return mixed
     */
    public function get($key)
    {
        return $this->dataspace->get($key);
    }

    /**
     * Удаляет значение с ключом $key
     *
     * @param string|integer $key ключ
     * @return true
     */
    public function delete($key)
    {
        return $this->dataspace->delete($key);
    }

    /**
     * Проверяет существует ли значение с ключом $key
     *
     * @param string|integer $key ключ
     * @return boolean
     */
    public function exists($key)
    {
        return $this->dataspace->exists($key);
    }

}

?>