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

class userMapper extends simpleMapper
{
    protected $name = 'user';
    protected $className = 'user';

    public function create()
    {
        return new user($this->getMap());
    }

    public function searchById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM `" . $this->table . "` WHERE `id` = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch();

        if ($row) {
            return $this->createUserFromRow($row);
        } else {
            return $this->getGuest();
        }
    }

    public function searchByLogin($login)
    {
        $stmt = $this->db->prepare("SELECT * FROM `" . $this->table . "` WHERE `login` = :login");
        $stmt->bindParam(':login', $login);
        $stmt->execute();

        $row = $stmt->fetch();

        if ($row) {
            return $this->createUserFromRow($row);
        } else {
            return $this->getGuest();
        }
    }

    public function login($login, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM `" . $this->table . "` WHERE `login` = :login AND `password` = :password");
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', md5($password));
        $stmt->execute();

        $row = $stmt->fetch();

        $toolkit = systemToolkit::getInstance();
        $session = $toolkit->getSession();

        if ($row) {
            $session->set('user_id', $row['id']);
            return $this->createUserFromRow($row);
        } else {
            $session->set('user_id', 1);
            return $this->getGuest();
        }
    }

    protected function createUserFromRow($row)
    {
        $map = $this->getMap();
        $user = new user($map);
        $user->import($row);
        return $user;
    }

    private function getGuest()
    {
        return $this->searchById(1);
    }

    protected function getMap()
    {
        if (empty($this->map)) {
            $mapFileName = fileLoader::resolve($this->name() . '/maps/user.map.ini');
            $this->map = parse_ini_file($mapFileName, true);
        }
        return $this->map;
    }
}

?>