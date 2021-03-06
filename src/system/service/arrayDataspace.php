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

/**
 * arrayDataspace: контейнер для удобной работы с массивами
 *
 * @package system
 * @subpackage dataspace
 * @version 0.2.1
 */
class arrayDataspace implements ArrayAccess, Iterator, Countable
{
    /**
     * Массив для хранения данных
     *
     * @var array
     */
    protected $data;
    protected $current = 0;

    /**
     * Принимает обычный массив $data с данными по умолчанию и
     * импортирует их в dataspace
     *
     * @param array $data
     */
    public function __construct($data = array())
    {
        $this->import($data);
    }

    /**
     * Устанавливает значение
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
     * @param string|integer $key ключ
     * @return mixed
     */
    public function get($key)
    {
        if (!is_scalar($key)) {
            throw new mzzInvalidParameterException("Key is not scalar", $key);
        }

        return (isset($this->data[$key])) ? $this->data[$key] : null;
    }

    /**
     * Проверяет существует ли значение с ключом $offset
     * с помощью операторов для массивов
     *
     * @param string|integer $offset
     * @return boolean
     * @see ArrayAccess::offsetExists()
     * @see exists()
     */
    public function offsetExists($offset)
    {
        return $this->exists($offset);
    }

    /**
     * Возвращает значение с ключом $offset с помощью операторов для массивов
     *
     * @param string|integer $offset
     * @return mixed
     * @see ArrayAccess::offsetGet()
     * @see get()
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * Устанавливает значение с ключом $offset с помощью операторов для массивов
     *
     * @param string|integer $offset
     * @param mixed $value
     * @return boolean
     * @see ArrayAccess::offsetSet()
     * @see set()
     */
    public function offsetSet($offset, $value)
    {
        return $this->set($offset, $value);
    }

    /**
     * Удаляет значение с ключом $offset с помощью операторов для массивов
     *
     * @param string|integer $offset
     * @return boolean
     * @see ArrayAccess::offsetUnset()
     * @see delete()
     */
    public function offsetUnset($offset)
    {
        return $this->delete($offset);
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
     * Возвращает количество элементов в dataspace
     *
     * @return integer
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * Алиас arrayDataspace::exists()
     *
     * @param string|integer $key ключ
     * @see arrayDataspace::exists()
     * @return boolean
     */
    public function has($key)
    {
        return $this->exists($key);
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
    public function &export()
    {
        return $this->data;
    }

    /**
     * Очищает все установленные данные
     *
     */
    public function clear()
    {
        $this->data = array();
    }

    /**
     * Проверяет является ли Dataspace пустым
     *
     * @return boolean
     */
    public function isEmpty()
    {
        return empty($this->data);
    }

    public function current()
    {
        return current($this->data);
    }

    public function key()
    {
        return key($this->data);
    }

    public function next()
    {
        $this->current++;
        return next($this->data);
    }

    public function rewind()
    {
        $this->current = 0;
        return reset($this->data);
    }

    public function first()
    {
        return $this->rewind();
    }

    public function last()
    {
        end($this->data);
        return $this->current();
    }

    public function valid()
    {
        return $this->current < sizeof($this->data);
    }

    /**
     * Extracts the item using name specified with []. Sample:
     * [first], [last], [phone][1], ...
     *
     * @param string $name the []-using name
     * @param array $array source array
     * @return mixed|null
     */
    public static function extractFromArray($name, $array)
    {
        if (!is_array($array)) {
            return null;
        }
        // extracting indexes (empty index equals 0)
        $name = str_replace('[]', '[0]', $name);
        preg_match_all('/\[["\']?(.*?)["\']?\]/', $name, $indexes);
        // or str_replace(array('[]', '][', '[', ']'), array('', '[', '[', ''), substr($name, strpos($name, '[') + 1));
        $indexes = $indexes[1];

        // iterating over the array
        foreach ($indexes as $index) {
            if (!isset($array[$index])) {
                $array = null;
                break;
            }
            $array = $array[$index];
        }

        return $array;
    }
}
?>