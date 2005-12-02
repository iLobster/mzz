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
     * ����� �������� � ��
     *
     * @var int
     * @access private
     */
    private $queries_num = 0;

    /**
     * ���������� ����������� mysqli: ��� ���������� � �� ��������������� ��������� SQL-����.
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
        /* ���������� ������������� ��������� ����� ����� set_charset, �� �������� � PHP>=5.1.0RC1,
         * �� � ���� PHP 5.1.0 RC5 � �������� 'Call to undefined method'. ������� ������ ���
         * �������� ����� ������ ���� PHP ��������� � MySQL > 4.1.�/5.�.�.
         * ��� ���������� ������������� ������������ ������ ������ �� ��������� ���������. */
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
    * ���������� ������������ ����� ��� �������� ����� ��������
    *
    * @param string $query ������ � ��
    * @param int $resultmode ���, � ������� ������� ���������
    * @return object
    */
   public function query($query, $resultmode = MYSQLI_STORE_RESULT)
   {
       $this->queries_num++;
       return parent::query($query, $resultmode);
   }

   /**
    * ����� ��� ��������� ����� ��������
    *
    * @return int ����� ��������
    */
   public function getQueriesNum()
   {
       return $this->queries_num;
   }
}
?>