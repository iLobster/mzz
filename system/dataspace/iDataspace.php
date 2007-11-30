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
 * iDataspace: интерфейс Dataspace
 *
 * @package system
 * @subpackage dataspace
 * @version 0.1
 */
interface iDataspace
{
    /**
     * Сохранение значения
     *
     * @param string|integer $key ключ для доступа к значению
     * @param mixed $value значение
     * @return true
     */
    public function set($key, $value);

    /**
     * Возвращает значение по ключу
     *
     * @param string|intger $key ключ
     * @return mixed
     */
    public function get($key);

    /**
     * Удаляет значение с ключом $key
     *
     * @param string|integer $key ключ
     * @return true
     */
    public function delete($key);

    /**
     * Проверяет существует ли значение с ключом $key
     *
     * @param string|integer $key ключ
     * @return boolean
     */
    public function exists($key);
}
?>