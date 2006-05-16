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

    public function create()
    {
        return new user($this->getMap());
    }

    protected function insert($user)
    {
        $fields = $user->export();
        if (sizeof($fields) > 0) {

            $field_names = '`' . implode('`, `', array_keys($fields)) . '`';
            $markers  = ':' . implode(', :', array_keys($fields));

            $stmt = $this->db->prepare('INSERT INTO `' . $this->table . '` (' . $field_names . ') VALUES (' . $markers . ')');

            $stmt->bindArray($fields);

            $id = $stmt->execute();

            $fields['id'] = $id;

            $user->import($fields);
        }
    }

    protected function update($user)
    {
        $fields = $user->export();
        if (sizeof($fields) > 0) {

            $query = '';
            foreach(array_keys($fields) as $val) {
                $query .= '`' . $val . '` = :' . $val . ', ';
            }
            $query = substr($query, 0, -2);
            $stmt = $this->db->prepare('UPDATE  `' . $this->table . '` SET ' . $query . ' WHERE `id` = :id');

            $stmt->bindArray($fields);
            $stmt->bindParam(':id', $user->getId(), PDO::PARAM_INT);


            $user->import($fields);

            return $stmt->execute();
        }

        return false;
    }

    public function delete($user)
    {
        $stmt = $this->db->prepare('DELETE FROM `' . $this->table . '` WHERE `id` = :id');
        $stmt->bindParam(':id', $user->getId(), PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function save($user)
    {
        if ($user->getId()) {
            $this->update($user);
        } else {
            $this->insert($user);
        }
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

    private function createUserFromRow($row)
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

    private function getMap()
    {
        if (empty($this->map)) {
            $mapFileName = fileLoader::resolve($this->getName() . '/maps/user.map.ini');
            $this->map = parse_ini_file($mapFileName, true);
        }
        return $this->map;
    }
}

?>