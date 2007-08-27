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
 * @package system
 * @subpackage dataspace
 * @version $Id$
*/

fileLoader::load('dataspace/iDataspace');

/**
 * arrayDataspace: ����� ��� ���������� � ������� � ������ ����� ������
 *
 * @package system
 * @subpackage dataspace
 * @version 0.1
 */
class arrayDataspace implements iDataspace, ArrayAccess
{
    /**
     * ������ ��� �������� ������
     *
     * @var array
     */
    protected $data;

    /**
     * �����������. ��������� ������ $data � �������
     *
     * @param array $data
     */
    public function __construct($data = array())
    {
        $this->import($data);
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

        $this->data[$key] = $value;
        return true;
    }

    /**
     * ���������� �������� �� �����
     *
     * @param string|integer $key ����
     * @return mixed
     */
    public function get($key)
    {
        if (!is_scalar($key)) {
            throw new mzzInvalidParameterException("Key is not scalar", $key);
        }

        return (isset($this->data[$key])) ? $this->data[$key] : null;
    }

    public function offsetExists($offset)
    {
        return $this->exists($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        return $this->get($offset, $value);
    }

    public function offsetUnset($offset)
    {
        return $this->delete($offset);
    }

    /**
     * ������� �������� � ������ $key
     *
     * @param string|integer $key ����
     * @return true
     */
    public function delete($key)
    {
        unset($this->data[$key]);
        return true;
    }

    /**
     * ��������� ���������� �� �������� � ������ $key
     *
     * @param string|integer $key ����
     * @return boolean
     */
    public function exists($key)
    {
        if (!is_scalar($key)) {
            throw new mzzInvalidParameterException("Key is not scalar", $key);
        }
        return isset($this->data[$key]);
    }

    /**
     * ������ ������� � Dataspace
     *
     * @param array $data
     */
    public function import(Array $data)
    {
        $this->data = $data;
    }

    /**
     * ������� ������� �� Dataspace
     *
     * @return array
     */
    public function & export()
    {
        return $this->data;
    }

    /**
    * ������� Dataspace
    *
    */
    public function clear()
    {
        $this->data = array();
    }

    /**
    * ��������� �������� �� Dataspace ������
    *
    */
    public function isEmpty()
    {
        return empty($this->data);
    }
}
?>