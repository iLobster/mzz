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
 * changeableDataspaceFilter: write/read фильтры
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
     * Конструктор
     *
     * @param iDataspace $dataspace
     */
    public function __construct(iDataspace $dataspace)
    {
        $this->dataspace = $dataspace;
    }

    /**
     * Устанавливает read-фильтр
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
     * Устанавливает write-фильтр
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
     * Сохранение значения
     *
     * @param string|integer $key ключ для доступа к значению
     * @param mixed $value значение
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
     * Возвращает значение по ключу
     *
     * @param string|intger $key ключ
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
     * Удаляет значение с ключом $key
     *
     * @param string|integer $key ключ
     * @return true
     */
    public function delete($key)
    {
        $this->dataspace->delete($key);
    }

    /**
     * Проверяет существует ли значение с ключом $key
     *
     * @param string|integer $key ключ
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