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
 * DB: класс, обеспечивающий доступ к драйверам баз данных
 *
 * @package system
 * @subpackage db
 * @version 0.3
*/
class DB
{
    const DEFAULT_CONFIG_NAME = 'default';

    /**
     * Array of Different Instances
     *
     * @var object
     */
    protected static $instances = array();

    /**
     * The factory method
     *
     * @param string $alias ключ массива [systemConfig::$dbMulti] с данными о доп. соединении
     * @param array $configs configurations (if passed as null, the system configurations will be used)
     *
     * @return object
     */
    public static function factory($alias = self::DEFAULT_CONFIG_NAME, $configs = null)
    {
        $configs = empty($configs) ? systemConfig::$db : $configs;

        if (!isset($configs[$alias])) {
            throw new mzzUnknownDBConfigException($configName);
        }

        $config = $configs[$alias];
        if (!isset(self::$instances[$alias])) {
            $driverName = systemConfig::$db[$alias]['driver'];
            $driver = 'mzz' . ucfirst($driverName);

            fileLoader::load('db/drivers/' . $driver);

            $dsn      = isset(systemConfig::$db[$alias]['dsn']) ? systemConfig::$db[$alias]['dsn'] : '';
            $username = isset(systemConfig::$db[$alias]['user']) ? systemConfig::$db[$alias]['user'] : '';
            $password = isset(systemConfig::$db[$alias]['password']) ? systemConfig::$db[$alias]['password'] : '';
            $charset  = isset(systemConfig::$db[$alias]['charset']) ? systemConfig::$db[$alias]['charset'] : '';
            $options = isset(systemConfig::$db[$alias]['options']) ? systemConfig::$db[$alias]['options'] : array();
            $tablePrefix = isset(systemConfig::$db[$alias]['tablePrefix']) ? systemConfig::$db[$alias]['tablePrefix'] : '';

            $dbType = strtolower(substr($dsn, 0, strpos($dsn, ':')));

            //@todo: хак для php5.3, в котором забыли положить PDO::MYSQL_ATTR_INIT_COMMAND
            $version_compare = version_compare(PHP_VERSION, '5.3.0');
            if ($version_compare !== 0 && $charset && $dbType == 'mysql') {
                $options[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES `' . $charset . '`';
            }

            self::$instances[$alias] = new $driver($dsn, $username, $password, $options);
            self::$instances[$alias]->setTablePrefix($tablePrefix);

            //@todo: хак для php5.3, в котором забыли положить PDO::MYSQL_ATTR_INIT_COMMAND
            if ($version_compare === 0 && $charset && $dbType == 'mysql') {
                self::$instances[$alias]->query('SET NAMES `' . $charset . '`');
            }

            if (in_array($dbType, array('mssql', 'dblib'))) {
                self::$instances[$alias]->query('SET ANSI_NULLS ON');
                self::$instances[$alias]->query('SET ANSI_WARNINGS ON');
            }
        }

        return self::$instances[$alias];
    }
}
?>