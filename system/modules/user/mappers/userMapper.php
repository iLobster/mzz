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
 * userMapper: ������ ��� �������������
 *
 * @package user
 * @version 0.2
 */

class userMapper extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'user';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'user';

    /**
     * ������ ���������� �������
     *
     * @var array
     */
    protected $cacheable = array('searchById', 'searchByLogin');

    /**
     * ������� ������ ������ DO
     *
     * @return object
     */
    public function create()
    {
        return new user($this->getMap());
    }

    /**
     * ��������� ����� ������� �� ��������������
     *
     * @param integer $id �������������
     * @return object
     */
    public function searchById($id)
    {
        $stmt = $this->searchByField('id', $id);
        $row = $stmt->fetch();

        if ($row) {
            return $this->createUserFromRow($row);
        } else {
            return $this->getGuest();
        }
    }

    /**
     * ��������� ����� ������� �� ������
     *
     * @param string $login �����
     * @return object
     */
    public function searchByLogin($login)
    {
        $stmt = $this->searchByField('login', $login);
        $row = $stmt->fetch();

        if ($row) {
            return $this->createUserFromRow($row);
        } else {
            return $this->getGuest();
        }
    }

    /**
     * �������������� ������������ �� ������ � ������ �
     * � ������ ������ ������������� ������
     * ������������������� ������������
     *
     * @param string $login �����
     * @param string $password ������
     * @return object
     */
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

    /**
     * ������� ������ user �� �������
     *
     * @param array $row
     * @return object
     */
    protected function createUserFromRow($row)
    {
        $map = $this->getMap();
        $user = new user($map);
        $user->import($row);
        return $user;
    }

    /**
     * ���������� ������ ��� ����� (id = 1)
     *
     * @return object
     */
    private function getGuest()
    {
        return $this->searchById(1);
    }

    /**
     * Magic method __sleep
     *
     * @return array
     */
    public function __sleep()
    {
        return array('name', 'section', 'tablePostfix', 'cacheable', 'className', 'table');
    }

    /**
     * Magic method __wakeup
     *
     */
    public function __wakeup()
    {
    }
}

?>