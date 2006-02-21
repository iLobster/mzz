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

fileLoader::load('dataspace/iValueFilter');
/**
 * changeableDataspaceFilter: write/read �������
 *
 */
class changeableDataspaceFilter implements iDataspace
{
    /**
     * Dataspace
     *
     * @var iDataspace
     */
    protected $dataspace;

    /**
     * Read filters
     *
     * @var array
     */
    protected $readFilters;

    /**
     * Write filters
     *
     * @var array
     */
    protected $writeFilters;

    /**
     * �����������
     *
     * @param iDataspace $dataspace
     */
    public function __construct(iDataspace $dataspace)
    {
        $this->dataspace = $dataspace;
    }

    /**
     * ������������� read-������
     *
     * @param string $key
     * @param iValueFilter $filter
     */
    public function addReadFilter($key, iValueFilter $filter)
    {
        if(!is_string($key)) {
            throw new mzzInvalidParameterException('Must be string', $key);
        }
        $this->readFilters[$key] = $filter;
    }

    /**
     * ������������� write-������
     *
     * @param string $key
     * @param iValueFilter $filter
     */
    public function addWriteFilter($key, iValueFilter $filter)
    {
        if(!is_string($key)) {
            throw new mzzInvalidParameterException('Must be string', $key);
        }
        $this->writeFilters[$key] = $filter;
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
        if(isset($this->writeFilters[$key])) {
            $value = $this->writeFilters[$key]->filter($value);
        }

        $this->dataspace->set($key, $value);
    }

    /**
     * ���������� �������� �� �����
     *
     * @param string|intger $key ����
     * @return mixed
     */
    public function get($key)
    {
        $value = $this->dataspace->get($key);

        if(isset($this->readFilters[$key])) {
            return $this->readFilters[$key]->filter($value);
        } else {
            return $value;
        }
    }

     /**
     * ������� �������� � ������ $key
     *
     * @param string|integer $key ����
     * @return true
     */
    public function delete($key)
    {
        $this->dataspace->delete($key);
    }

    /**
     * ��������� ���������� �� �������� � ������ $key
     *
     * @param string|integer $key ����
     * @return boolean
     */
    public function exists($key)
    {
        $this->dataspace->exists($key);
    }

    /**
     * Call
     *
     * @param string $methodName
     * @param array $args
     * @return mixed
     */
    final public function __call($methodName, $args)
    {
        return call_user_func_array(array($this->dataspace, $methodName), $args);
    }

}
?>