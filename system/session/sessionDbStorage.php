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
fileLoader::load('session/iSessionStorage');

class sessionDbStorage implements iSessionStorage
{
    protected $db;

    public function __construct()
    {

        $this->db = DB::factory();

    }

    /**
     * Открытие хранилища сессий
     *
     * @return bool
     */
    public function storageOpen()
    {
        return true;
    }

    /**
     * Закрытие хранилища сессий
     *
     * @return bool
     */

    public function storageClose()
    {
        return true;
    }

    /**
     * Чтение сессии из хранилища
     *
     * @param string $sid Идентификатор сессии
     * @return string
     */
    public function storageRead($sid)
    {

        $stmt = $this->db->prepare("SELECT `data` FROM `sessions` WHERE `sid` = :sid AND `valid` = 'yes'");
        $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_NUM);

        if ($row) {
            return $row[0];
        } else {
            return null;

        }
    }

    /**
     * Запись значения сессии в хранилище
     *
     * @param string $sid   Идентификатор сессии
     * @param string $value Значение сессии
     * @return string
     */
    public function storageWrite($sid, $value)
    {
        $this->db->exec(' INSERT INTO `sessions` (`sid`,`data`,`ts`)'.
                        " VALUES('$sid','$value',NOW())");

        return true;
    }

    /**
     * Уничтожение сессии из хранилища
     *
     * @param string $sid Идентификатор сессии
     * @return string
     */
    public function storageDestroy($sid)
    {
        $this->db->exec(' UPDATE `sessions`'.
                        " SET `valid` = 'no'".
                        " WHERE `sid` = '$sid'");
        return true;
    }

    /**
     * Установка продолжительности жизни сессии
     *
     * @param string $maxLifeTime Время жизни сессии в секундах
     * @return string
     */
    public function storageGc($maxLifeTime)
    {
        $this->db->exec(' UPDATE `sessions`'.
                        " SET  `valid`  = 'no'".
                        " WHERE `valid` = 'yes'".
                        " AND ts < DATE_ADD(now(), INTERVAL - $maxLifeTime SECOND)");
        return true;
    }


}


?>