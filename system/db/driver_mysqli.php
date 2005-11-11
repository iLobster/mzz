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
 * MzzMysqli - ������� ��� ������ � ����� ������ MySQL ������ 4.1 � ����
 *
 * @package system
 * @version 0.1
 */
class MzzMysqli extends mysqli {
    /**
     * ���������������� ����������� mysqli, ��������� ��������� ���������
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

        /* ���������� ������������� ��������� ����� ����� set_charset, �� �������� � PHP>=5.1.0RC1,
         * �� � ���� PHP 5.1.0 RC5 � �������� 'Call to undefined method' */
        //$this->set_charset(DB_CHARSET);
        $this->query("SET NAMES `".DB_CHARSET."`");

    }
}
?>