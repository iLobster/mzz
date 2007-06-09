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
 * @subpackage session
 * @version $Id$
*/

/**
 * session: класс для работы с сессией
 *
 * @package system
 * @subpackage session
 * @version 0.1.2
*/
class session
{
    /**
     * Драйвер хранилища сессий
     *
     * @var iSessionStorage
     */
    protected $storageDriver;

    /**
     * Запуск сессии
     *
     */
    public function __construct(iSessionStorage $storageDriver = null)
    {
        if(!empty($storageDriver)) {
            $this->storageDriver = $storageDriver;
        }
    }

    /**
     * Запуск сессии
     *
     */
    public function start()
    {
        if($this->storageDriver) {
                session_set_save_handler(
                array($this->storageDriver, 'storageOpen'),
                array($this->storageDriver, 'storageClose'),
                array($this->storageDriver, 'storageRead'),
                array($this->storageDriver, 'storageWrite'),
                array($this->storageDriver, 'storageDestroy'),
                array($this->storageDriver, 'storageGc'));
        }
        session_start();
        
        // исправление уязвимости 'session fixation'
        $hash = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
        if (!isset($_SESSION['mzz_session_fixation']) || $_SESSION['mzz_session_fixation'] != $hash) {
            session_regenerate_id();
            $_SESSION = array();
            $_SESSION['mzz_session_fixation'] = $hash;
        }
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
        return ($this->exists($name)) ? unserialize($_SESSION[$name]) : $default_value;
    }

    /**
     * Устанавливает значение в сессии
     *
     * @param string $name ключ
     * @param string $value значение
     */
    public function set($name, $value)
    {
        $_SESSION[$name] = serialize($value);
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

    /**
     * Возвращает текущий идентификатор сессии
     *
     * @return string
     */
    public function getId()
    {
        return session_id();
    }
}

?>