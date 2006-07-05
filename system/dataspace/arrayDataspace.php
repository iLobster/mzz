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
 * arrayDataspace: класс для сохранение и доступа к данным через массив
 *
 * @package system
 * @subpackage dataspace
 * @version 0.1
 */
class arrayDataspace implements iDataspace
{
    /**
     * Массив для хранения данных
     *
     * @var array
     */
    protected $data;

    /**
     * Конструктор. Принимает массив $data с данными
     *
     * @param array $data
     */
    public function __construct($data = array())
    {
        $this->import($data);
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

        $this->data[$key] = $value;
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
        if (!is_scalar($key)) {
            throw new mzzInvalidParameterException("Key is not scalar", $key);
        }

        return ($this->exists($key)) ? $this->data[$key] : null;
    }

    /**
     * Удаляет значение с ключом $key
     *
     * @param string|integer $key ключ
     * @return true
     */
    public function delete($key)
    {
        unset($this->data[$key]);
        return true;
    }

    /**
     * Проверяет существует ли значение с ключом $key
     *
     * @param string|integer $key ключ
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
     * Импорт массива в Dataspace
     *
     * @param array $data
     */
    public function import(Array $data)
    {
        $this->data = $data;
    }

    /**
     * Экспорт массива из Dataspace
     *
     * @return array
     */
    public function export()
    {
        return $this->data;
    }

    /**
    * Очистка Dataspace
    *
    */
    public function clear()
    {
        $this->data = array();
    }
}
?>