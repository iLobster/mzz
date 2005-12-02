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
 * MzzMysqli: драйвер для работы с базой данных MySQL версии 4.1 и выше
 *
 * @package system
 * @version 0.3
 */
class MzzMysqli extends mysqli {
    /**
     * Singleton
     *
     * @var object
     * @access private
     * @static
     */
    private static $instance;

    /**
     * число запросов к БД
     *
     * @var int
     * @access private
     */
    private $queries_num = 0;

    /**
     * Декорируем конструктор mysqli: при соединении с БД устанавливается кодировка SQL-базы.
     *
     * @param string $host
     * @param string $username
     * @param string $passwd
     * @param string $dbname
     * @param integer $port
     * @param string $socket
     * @access public
     * @return void
     */
    public function __construct($host=null, $username=null, $passwd=null, $dbname=null, $port=0, $socket=null)
    {
        parent::__construct($host, $username, $passwd, $dbname, $port, $socket);
        $registry = Registry::instance();
        $config = $registry->getEntry('config');
        $config->load('common');
        /* Правильнее устанавливать кодировку через метод set_charset, он добавлен в PHP>=5.1.0RC1,
         * но у меня PHP 5.1.0 RC5 и ругается 'Call to undefined method'. Удалось узнать что
         * Работать будет только если PHP собирался с MySQL > 4.1.х/5.х.х.
         * Для нормальной совместимости используется прямой запрос на установку кодировки. */
        $this->query("SET NAMES `" . $config->getOption('db', 'charset') . "`");
    }

    /**
     * The singleton method
     *
     * @access public
     * @static
     * @return object
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
                $classname = __CLASS__;
                $registry = Registry::instance();
                $config = $registry->getEntry('config');
                $config->load('common');
                $host = $config->getOption('db', 'host');
                $user = $config->getOption('db', 'user');
                $passwd = $config->getOption('db', 'password');
                $base = $config->getOption('db', 'base');
                self::$instance = new $classname($host, $user, $passwd, $base);
        }
        return self::$instance;
   }

   /**
    * Декорирует оригинальный метод для подсчета числа запросов
    *
    * @param string $query запрос к БД
    * @param int $resultmode тип, в котором выдаётся результат
    * @return object
    */
   public function query($query, $resultmode = MYSQLI_STORE_RESULT)
   {
       $this->queries_num++;
       return parent::query($query, $resultmode);
   }

   /**
    * метод для получения числа запросов
    *
    * @return int число запросов
    */
   public function getQueriesNum()
   {
       return $this->queries_num;
   }
}
?>