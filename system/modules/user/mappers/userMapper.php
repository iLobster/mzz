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

class userMapper
{
    private $db;
    private $table;
    private $section;
    private $map = array();

    public function __construct($section)
    {
        $this->db = DB::factory();
        $this->section = $section;
        $this->table = $this->getName() . '_' .$this->getSection();
    }

    private function getName()
    {
        return 'user';
    }

    private function getSection()
    {
        return $this->section;
    }

    public function create()
    {
        return new user($this, $this->getMap());
    }

    protected function insert($user)
    {
        $fields = $user->extract();
        if (sizeof($fields) > 0) {
            if (isset($fields['password'])) {
                $fields['password'] = md5($fields['password']);
            }
            
            $field_names = '`' . implode('`, `', array_keys($fields)) . '`';
            $markers  = ':' . implode(', :', array_keys($fields));

            $stmt = $this->db->prepare('INSERT INTO `' . $this->table . '` (' . $field_names . ') VALUES (' . $markers . ')');

            $stmt->bindArray($fields);

            $id = $stmt->execute();
            
            $fields['id'] = $id;
            
            $user->uploadData($fields);
        }
    }

    protected function update($user)
    {
        $fields = $user->extract();
        if (sizeof($fields) > 0) {
            if (isset($fields['password'])) {
                $fields['password'] = md5($fields['password']);
            }
            
            $query = '';
            foreach(array_keys($fields) as $val) {
                $query .= '`' . $val . '` = :' . $val . ', ';
            }
            $query = substr($query, 0, -2);
            $stmt = $this->db->prepare('UPDATE  `' . $this->table . '` SET ' . $query . ' WHERE `id` = :id');

            $stmt->bindArray($fields);
            $stmt->bindParam(':id', $user->getId(), PDO::PARAM_INT);
            
            
            $user->uploadData($fields);

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

        /*$dateFilter = new dateFormatValueFilter();
        $fields = new changeableDataspaceFilter(new arrayDataspace(array()));
        $fields->addReadFilter('created', $dateFilter);
        $fields->addReadFilter('updated', $dateFilter);*/

        $user = new user($this, $map);
/*
        foreach ($map as $key => $field) {
            $setprop = $field['mutator'];
            $value = $row[$key];
            if ($setprop && $value) {
                call_user_func(array($user, $setprop), $value);
            }
        }*/
        $user->uploadData($row);
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