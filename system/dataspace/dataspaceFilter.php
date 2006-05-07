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

/**
 * dataspaceFilter: ������ ��� Dataspace
 *
 * @package system
 * @version 0.1
 */
class dataspaceFilter implements iDataspace
{
    /**
     * ������ dataspace
     *
     * @var iDataspace
     */
    protected $dataspace;

    /**
     * �����������.
     *
     * @param iDataspace $dataspace
     */
    public function __construct(iDataspace $dataspace)
    {
        $this->dataspace = $dataspace;
    }

    /**
     * ���������� ��������
     *
     * @param string|integer $key ���� ��� ������� � ��������
     * @param mixed $value ��������
     * @return true
     */
    public function set($key, $value)
    {
        if (!is_scalar($key)) {
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