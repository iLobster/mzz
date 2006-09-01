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
 * @subpackage db
 * @version $Id$
*/

/**
 * DB: �����, �������������� ������ � ��������� ��� ������
 *
 * @package system
 * @subpackage db
 * @version 0.2
*/
class DB
{
    /**
     * Callback information
     */
    protected static $callback = false;

    /**
     * The factory method
     *
     * @param string $alias ���� ������� [systemConfig::$dbMulti] � ������� � ���. ����������
     *
     * @return object
     */
    public static function factory($alias = 'default')
    {        if(!isset(systemConfig::$db[$alias])) {
            $alias = 'default';
        }

        if (self::$callback == false) {
            $driverName = systemConfig::$db[$alias]['driver'];
            $driver = 'mzz' . ucfirst($driverName);

            fileLoader::load('db/drivers/' . $driver);
            self::$callback = array($driver, 'getInstance');
        }

        if (!is_callable(self::$callback)) {
            self::$callback = false;
            throw new mzzCallbackException(self::$callback);
            return false;
        } else {
            return call_user_func(self::$callback, $alias);
        }
    }



}
?>