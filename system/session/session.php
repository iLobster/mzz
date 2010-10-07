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
    public function __construct($storageDriver = null)
    {
        if(!empty($storageDriver)) {
            $driver = 'session' . ucfirst($storageDriver) . 'Storage';
            fileLoader::load('session/' . $driver);
            $this->storageDriver = new $driver();
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
        } else {
            session_save_path(systemConfig::$pathToTemp . '/sessions');
        }

        session_start();
        $request = systemToolkit::getInstance()->getRequest();

        // исправление уязвимости 'session fixation'
        $ip = $request->getServer('REMOTE_ADDR', '127.0.0.1');
        $useragent = $request->getServer('HTTP_USER_AGENT', 'no user agent');
        $charset = $request->getServer('HTTP_ACCEPT_CHARSET', 'hello from IE');
        $ip = substr($ip, 0, strrpos($ip, '.') - 1);
        $hash = md5($useragent . $ip . $charset);
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
        if (!isset($_SESSION)) {
            return false;
        }
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
            $matches = $this->explodeName($name);
            if (sizeof($matches['keys'])) {
                $data = $this->removeFromArray($this->get($matches['name']), $matches['keys']);
                $this->set($matches['name'], $data);
            } else {
                unset($_SESSION[$name]);
            }
        }
        return $exists;
    }

    protected function removeFromArray($arr, $keys, $current = null)
    {
        $new = array();
        if ($current === null) {
            $current = array_shift($keys);
        }
        foreach ($arr as $k => $val) {
            if ($current !== false && (string)$k == (string)$current) {
                if (($current = array_shift($keys)) && is_array($val)) {
                    $new[$k] = $this->removeFromArray($val, $keys, $current);
                }
            } else {
                $new[$k] = $val;
            }
        }
        return $new;
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