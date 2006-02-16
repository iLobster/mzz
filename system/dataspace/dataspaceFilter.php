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
     * ���������� �������� �� �����
     *
     * @param string|intger $key ����
     * @return mixed
     */
    public function get($key)
    {
        return $this->dataspace->get($key);
    }

    /**
     * ������� �������� � ������ $key
     *
     * @param string|integer $key ����
     * @return true
     */
    public function delete($key)
    {
        return $this->dataspace->delete($key);
    }

    /**
     * ��������� ���������� �� �������� � ������ $key
     *
     * @param string|integer $key ����
     * @return boolean
     */
    public function exists($key)
    {
        return $this->dataspace->exists($key);
    }

}

?>