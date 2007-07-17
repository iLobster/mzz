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
 * session: ����� ��� ������ � �������
 *
 * @package system
 * @subpackage session
 * @version 0.1.3
*/
class session
{
    /**
     * ������� ��������� ������
     *
     * @var iSessionStorage
     */
    protected $storageDriver;

    /**
     * ������ ������
     *
     */
    public function __construct(iSessionStorage $storageDriver = null)
    {
        if(!empty($storageDriver)) {
            $this->storageDriver = $storageDriver;
        }
    }

    /**
     * ������ ������
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

        // ����������� ���������� 'session fixation'
        $hash = md5((isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'UA doesnt exists') . $_SERVER['REMOTE_ADDR'] . (isset($_SERVER['HTTP_ACCEPT_CHARSET']) ? $_SERVER['HTTP_ACCEPT_CHARSET'] : 'fucking ie'));
        if (!$this->exists('mzz_session_fixation')) {
            $this->set('mzz_session_fixation', $hash);
        } elseif ($this->get('mzz_session_fixation') != $hash) {
            session_regenerate_id();
            $this->reset();
            $this->set('mzz_session_fixation', $hash);
        }
    }

    /**
     * �������� ������
     *
     */
    public function stop()
    {
        session_write_close();
    }

    /**
     * ���������� �������� �� ������
     *
     * @param string $name ����
     * @param string $get ������������ �������� ���� �������� � ������ $name �� ����������
     * @return mixed
     */
    public function get($name, $default_value = null)
    {
        return ($this->exists($name)) ? unserialize($_SESSION[$name]) : $default_value;
    }

    /**
     * ������������� �������� � ������
     *
     * @param string $name ����
     * @param string $value ��������
     */
    public function set($name, $value)
    {
        $_SESSION[$name] = serialize($value);
    }

    /**
     * ������� ������� ������
     *
     */
    public function reset()
    {
        $_SESSION = array();
    }

    /**
     * ��������� ���������� �� �������� � ������ $name � ������
     *
     * @param string $name ����
     * @return boolean
     */
    public function exists($name)
    {
        return isset($_SESSION[$name]);
    }

    /**
     * ������� �������� �� ������
     *
     * @param string $name ����
     */
    public function destroy($name)
    {
        if ($this->exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    /**
     * ���������� ������� ������������� ������
     *
     * @return string
     */
    public function getId()
    {
        return session_id();
    }
}

?>