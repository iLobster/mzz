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
 * session: класс для работы с сессией
 *
 * @package system
 * @version 0.1
*/


class session
{
    protected $storageDriver;

    /**
     * Запуск сессии
     *
     */
    public function __construct(iSessionStorage $storageDriver = null)
    {
        if(!empty($storageDriver))  $this->storageDriver = $storageDriver;

    }

    /**
     * Запуск сессии
     *
     */
    public function start()
    {
        if($this->storageDriver)
                session_set_save_handler(
                array($this->storageDriver, 'storageOpen'),
                array($this->storageDriver, 'storageClose'),
                array($this->storageDriver, 'storageRead'),
                array($this->storageDriver, 'storageWrite'),
                array($this->storageDriver, 'storageDestroy'),
                array($this->storageDriver, 'storageGc'));

        session_start();
    }

    /**
     * Возвращает значение из сессии
     *
     * @param string $name ключ
     * @param string $get возвращаемое значение если значение с ключом $name не существует
     * @return string|null
     */
    public function get($name, $default_value = null)
    {
        return ($this->exists($name)) ? $_SESSION[$name] : $default_value;
    }

    /**
     * Устанавливает значение в сессии
     *
     * @param string $name ключ
     * @param string $value значение
     */
    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Очищает текущую сессию
     *
     */
    public function reset()
    {
        $_SESSION = array();
    }

    /**
     * Проверяет существует ли значение с ключом $name в сессии
     *
     * @param string $name ключ
     * @return boolean
     */
    public function exists($name)
    {
        return isset($_SESSION[$name]);
    }

    /**
     * Удаляет значение из сессии
     *
     * @param string $name ключ
     */
    public function destroy($name)
    {
        if ($this->exists($name)) {
            unset($_SESSION[$name]);
        }
    }
}

?>