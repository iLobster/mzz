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
 * MzzMysqli: ������� ��� ������ � ����� ������ MySQL ������ 4.1 � ����
 *
 * @package system
 * @version 0.3
 */
class mzzPdo extends PDO {
    /**
     * Singleton
     *
     * @var object
     */
    private static $instance;

    /**
     * ����� �������� � ��
     *
     * @var int
     */
    private $queriesNum = 0;

    /**
     * ����� ����� �������� � ��
     *
     * @var float
     */
    private $queriesTime = 0;

    /**
     * ���������� ����������� mysqli: ��� ���������� � �� ��������������� ��������� SQL-����.
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
                //$options = $config->getOption('db', 'options');
                self::$instance = new $classname($dsn, $username, $password, $charset);
        }
        return self::$instance;
   }

   /**
    * ���������� ������������ ����� ��� �������� ����� ��������
    *
    * @param string $query ������ � ��
    * @param int $resultmode ���, � ������� ������� ���������
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
    * ����� ��� ��������� ����� ��������
    *
    * @return int ����� ��������
    */
   public function getQueriesNum()
   {
       return $this->queriesNum;
   }

   /**
    * ����� ��� ��������� ������ ������� ���������� �������
    *
    * @return float ����� � ��������
    */
   public function getQueriesTime()
   {
       return $this->queriesTime;
   }
}
?>