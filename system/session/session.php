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
    /**
     * ������ ������
     *
     */
    public function start()
    {
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
        if($this->exists($name)) {
            unset($_SESSION[$name]);
        }
    }
}

?>