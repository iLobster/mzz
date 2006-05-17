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
 * session: ����� ��� ������ � �������
 *
 * @package system
 * @version 0.1
*/


class session
{
    protected $storageDriver;

    /**
     * ������ ������
     *
     */
    public function __construct(iSessionStorage $storageDriver = null)
    {
        if(!empty($storageDriver))  $this->storageDriver = $storageDriver;

    }

    /**
     * ������ ������
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
     * ���������� �������� �� ������
     *
     * @param string $name ����
     * @param string $get ������������ �������� ���� �������� � ������ $name �� ����������
     * @return string|null
     */
    public function get($name, $default_value = null)
    {
        return ($this->exists($name)) ? $_SESSION[$name] : $default_value;
    }

    /**
     * ������������� �������� � ������
     *
     * @param string $name ����
     * @param string $value ��������
     */
    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
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
}

?>