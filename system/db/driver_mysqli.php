<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2005
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * MzzMysqli: драйвер для работы с базой данных MySQL версии 4.1 и выше
 *
 * @package system
 * @version 0.2
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
     * Переопределенный конструктор mysqli, добавлена установка кодировки
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
    public function __construct($host=null, $username=null, $passwd=null, $dbname=null, $port=0, $socket=null) {
        parent::__construct($host, $username, $passwd, $dbname, $port, $socket);
        $config = configFactory::getInstance();
        $config->load('common');
        /* Правильнее устанавливать кодировку через метод set_charset, он добавлен в PHP>=5.1.0RC1,
         * но у меня PHP 5.1.0 RC5 и ругается 'Call to undefined method' */
        //$this->set_charset($config->getOption('db','charset'));
        $this->query("SET NAMES `".$config->getOption('db','charset')."`");

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
                $config = configFactory::getInstance();
                $config->load('common');
                $host = $config->getOption('db','host');
                $user = $config->getOption('db','user');
                $passwd = $config->getOption('db','password');
                $base = $config->getOption('db','base');
                self::$instance = new $classname($host, $user, $passwd, $base);
        }
        return self::$instance;
   }
}
?>