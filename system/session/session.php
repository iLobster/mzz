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
 * @version 0.1.3
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
        $ip = substr($_SERVER['REMOTE_ADDR'], 0, strrpos($_SERVER['REMOTE_ADDR'], '.') - 1);
        $hash = md5((isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'UA doesnt exists') . $ip . (isset($_SERVER['HTTP_ACCEPT_CHARSET']) ? $_SERVER['HTTP_ACCEPT_CHARSET'] : 'ie bug'));
        if (!$this->exists('mzz_session_fixation')) {
            $this->set('mzz_session_fixation', $hash);
        } elseif ($this->get('mzz_session_fixation') != $hash) {
            session_regenerate_id();
            $this->reset();
            $this->set('mzz_session_fixation', $hash);
        }
    }

    /**
     * Закрытие сессии
     *
     */
    public function stop()
    {
        session_write_close();
    }

    private function explodeName($name)
    {
        preg_match_all('/(.*)(?:\[(.*)\])+/U', $name, $matches);
        return array('name' => isset($matches[1][0]) ? $matches[1][0] : '', 'keys' => $matches[2]);
    }

    /**
     * Возвращает значение из сессии
     *
     * @param string $name ключ
     * @param string $get возвращаемое значение если значение с ключом $name не существует
     * @return mixed
     */
    public function get($name, $default_value = null)
    {
        $matches = $this->explodeName($name);

        if (sizeof($matches['keys'])) {
            if (!isset($_SESSION[$matches['name']])) {
                return $default_value;
            }

            $var =& $_SESSION[$matches['name']];
            foreach ($matches['keys'] as $key) {

                if (!isset($var[$key])) {
                    return $default_value;
                }
                $var =& $var[$key];
            }
        } else {
            if (!$this->exists($name)) {
                return $default_value;
            }

            $var =& $_SESSION[$name];
        }

        return $var;
    }

    /**
     * Устанавливает значение в сессии
     *
     * @param string $name ключ
     * @param string $value значение
     */
    public function set($name, $value)
    {
        $matches = $this->explodeName($name);

        if (sizeof($matches['keys'])) {
            $var =& $_SESSION[$matches['name']];
            foreach ($matches['keys'] as $key) {
                if (!isset($var[$key])) {
                    $var[$key] = array();
                }
                $var =& $var[$key];
            }
        } else {
            $var =& $_SESSION[$name];
        }
        $var = $value;
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
        $matches = $this->explodeName($name);

        if (sizeof($matches['keys'])) {
            if (!isset($_SESSION[$matches['name']])) {
                return false;
            }

            $var =& $_SESSION[$matches['name']];

            foreach ($matches['keys'] as $key) {
                if (!array_key_exists($key, $var)) {
                    return false;
                }
                $var =& $var[$key];
            }

            return true;
        }

        return array_key_exists($name, $_SESSION);
    }

    /**
     * Удаляет значение из сессии
     *
     * @param string $name ключ
     * @return boolean true если в сессии была запись для указанного ключа
     */
    public function destroy($name)
    {
        if ($exists = $this->exists($name)) {
            $this->set($name, null);
        }
        return $exists;
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