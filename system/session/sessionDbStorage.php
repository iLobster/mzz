<?php
//
// $Id: standart_header.txt 620 2006-05-07 18:03:00Z zerkms $
// $URL: svn://svn.subversion.ru/usr/local/svn/mzz/docs/standart_header.txt $
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
fileLoader::load('session/iSessionStorage');

class sessionDbStorage implements iSessionStorage
{
    protected $db;

    function __construct()
    {

        $this->db = DB::factory();

    }

    function storageOpen()
    {
        return true;
    }

    function storageClose()
    {
        return true;
    }

    function storageRead($sid)
    {

        $stmt = $this->db->prepare("SELECT `data` FROM `sessions` WHERE `id` = :id AND `valid` = 'yes'");
        $stmt->bindParam(':id', $sid, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_NUM);

        if ($row) {
            return $row[0];
        } else {
            return null;

        }
    }

    function storageWrite($sid, $value)
    {
        $this->db->exec(' INSERT INTO `sessions` (`id`,`data`,`ts`)'.
                        " VALUES('$sid','$value',NOW())");

        return true;
    }

    function storageDestroy($sid)
    {
        $this->db->exec(' UPDATE `sessions`'.
                        " SET `valid` = 'no'".
                        " WHERE `id` = '$sid'");
        return true;                
    }

    function storageGc($maxLifeTime)
    {
        $this->db->exec(' UPDATE `sessions`'.
                        " SET  `valid`  = 'no'".
                        " WHERE `valid` = 'yes'".
                          " AND ts < DATE_ADD(now(), INTERVAL - $maxLifeTime SECOND)");
        return true;
    }


}


?>