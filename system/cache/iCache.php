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
     * Добавляет данные в кэш. Если значение уже существует, то возвращает false
     *
     * @param $key идентификатор значения в кэшэ
     * @param $value кэшируемое значение
     * @param $expire количество секунд до того, как кэш будет просрочен
     * @param $params дополнительные параметры
     * @return bool
     */
    public function add($key, $value, $expire = null, $params = array());

    /**
     * Добавляет данные в кэш.
     *
     * @param $key идентификатор значения в кэшэ
     * @param $value кэшируемое значение
     * @param $expire количество секунд до того, как кэш будет просрочен
     * @param $params дополнительные параметры
     * @return bool
     */
    public function set($key, $value, $expire = null, $params = array());

    /**
     * Получает данные из кэша. Если такого значения нет в кэшэ, то возвращает false
     *
     * @param $key идентификатор значения в кэшэ
     * @return string|null
     */
    public function get($key);

    /**
     * Получает данные из кэша. Если такого значения нет в кэшэ, то возвращает false
     *
     * @param $key идентификатор значения в кэшэ
     * @param $params дополнительные параметры
     * @return bool
     */
    public function delete($key, $params = array());

    /**
     * Очищает весь кэш
     *
     * @param $params дополнительные параметры
     * @return bool
     */
    public function flush($params = array());
}
?>