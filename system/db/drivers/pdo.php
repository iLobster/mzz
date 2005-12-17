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
 * mzzPdo: драйвер для работы с базой данных через PDO
 *
 * @package system
 * @version 0.1
 */

fileLoader::load('db/drivres/mzzPdoStatement');

class mzzPdo extends PDO {
    /**
     * Singleton
     *
     * @var object
     */
    private static $instance;

    /**
     * число запросов к БД
     *
     * @var int
     */
    private $queriesNum = 0;

    /**
     * общее время запросов к БД
     *
     * @var float
     */
    private $queriesTime = 0;

    /**
     * Декорируем конструктор PDO: при соединении с БД устанавливается кодировка SQL-базы.
     *
     * @param string $host
     * @param string $username
     * @param string $passwd
     * @param string $dbname
     * @param integer $port
     * @param string $socket
     * @return void
     */
    public function __construct($dsn, $username='', $password='', $charset = '', $options=array())
    {
        parent::__construct($dsn, $username, $password, $options);
        $this->query("SET NAMES `" . $charset . "`");
    }

    /**
     * The singleton method
     *
     * @return object
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
                $classname = __CLASS__;
                $registry = Registry::instance();
                $config = $registry->getEntry('config');
                $config->load('common');
                $dsn = $config->getOption('db', 'dsn');
                $username = $config->getOption('db', 'user');
                $password = $config->getOption('db', 'password');
                $charset = $config->getOption('db', 'charset');
                // We add options-support later...
                // $options = $config->getOption('db', 'options');
                self::$instance = new $classname($dsn, $username, $password, $charset);
                self::$instance->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('mzzPdoStatement'));
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
   public function query($query)
   {
       $this->queriesNum++;
       $start_time = microtime(1);
       $result = parent::query($query);
       if($this->errorCode() != 0) {
           $code = $this->errorInfo();
           $info = $this->errorInfo();
           throw new mzzRuntimeException("SQL-Query error: " . implode(', ', $info), implode(', ', $code));
       }
       $this->queriesTime += (microtime(1) - $start_time);
       return $result;
   }

   /**
    * Декорирует оригинальный метод для подсчета числа запросов
    *
    * @param string $query запрос к БД
    * @return object
    */
   public function prepare($query)
   {
       $this->queriesNum++;
       $start_time = microtime(1);
       $stmt = parent::prepare($query);
       $this->queriesTime += (microtime(1) - $start_time);
       return $stmt;
   }

   /**
    * Декорирует оригинальный метод для подсчета числа запросов
    *
    * @param string $query запрос к БД
    * @return integer
    */
   public function exec($query)
   {
       $this->queriesNum++;
       $count = parent::exec($query);
       $this->queriesTime += (microtime(1) - $start_time);
       return $count;
   }

   /**
    * метод для получения числа запросов
    *
    * @return int число запросов
    */
   public function getQueriesNum()
   {
       return $this->queriesNum;
   }

   /**
    * метод для получения общего времени выполнения запроса
    *
    * @return float время в секундах
    */
   public function getQueriesTime()
   {
       return $this->queriesTime;
   }
}

?>