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
 * @subpackage toolkit
 * @version $Id$
*/

/**
 * iCache: интерфейс Cache
 *
 * @package system
 * @subpackage cache
 * @version 0.1
 */
interface iCache
{
    /**
     * Добавляет данные в кэш.
     *
     * @param mixed $key - идентификатор значения в кэшэ
     * @param mixed $value - кэшируемое значение
     * @param int[optional] $expire - количество секунд до того, как кэш будет просрочен
     * @param array[optional] $params - дополнительные параметры
     * @return bool
     */
    public function set($key, $value, $tags = array(), $expire = null);

    /**
     * Получает данные из кэша. Если такого значения нет в кэшэ, то возвращает false
     *
     * @param mixed $key - идентификатор значения в кэшэ
     * @return string|null
     */
    public function get($key);

    /**
     * Получает данные из кэша. Если такого значения нет в кэшэ, то возвращает false
     *
     * @param mixed $key идентификатор значения в кэшэ
     * @param array[optional] $params дополнительные параметры
     * @return bool
     */
    public function delete($key);

    /**
     * Очищает весь кэш
     *
     * @param array[optional] $params дополнительные параметры
     * @return bool
     */
    public function flush($params = array());
}
?>
