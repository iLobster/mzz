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
 * dataspaceFilter: фильтр для Dataspace
 *
 * @package system
 * @version 0.1
 */
class dataspaceFilter implements iDataspace
{
    /**
     * Объект dataspace
     *
     * @var iDataspace
     */
    protected $dataspace;

    /**
     * Конструктор.
     *
     * @param iDataspace $dataspace
     */
    public function __construct(iDataspace $dataspace)
    {
        $this->dataspace = $dataspace;
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
        if (!is_scalar($key)) {
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