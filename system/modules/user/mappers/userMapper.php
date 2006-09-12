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

fileLoader::load('user/mappers/groupMapper');

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
    //  protected $cacheable = array('searchById', 'searchByLogin');

    /**
     * �����������
     *
     * @param string $section ������
     */
    public function __construct($section)
    {
        parent::__construct($section);
        $this->relationTable = $this->table . '_group_rel';
    }

    /**
     * ������� ������ ������ DO
     *
     * @return object
     */
    public function create()
    {
        return new user($this, $this->getMap());
    }

    /**
     * ��������� ����� ������� �� ��������������
     *
     * @param integer $id �������������
     * @return object
     */
    public function searchById($id)
    {
        /*$stmt = $this->searchByField('id', $id);
        $row = $stmt->fetch();*/

        $row = $this->searchOneByField('id', $id);

        if ($row) {
            return $row;
        } else {
            if($id === MZZ_USER_GUEST_ID) {
                throw new mzzSystemException('����������� ������ � ID: ' . MZZ_USER_GUEST_ID . ' ��� ����� � ������� ' . $this->table);
            }
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
        /*        $stmt = $this->searchByField('login', $login);
        $row = $stmt->fetch();*/

        $row = $this->searchOneByField('login', $login);

        if ($row) {
            return $row;
        } else {
            return $this->getGuest();
        }
    }

    public function getGroups($id)
    {
        $groupMapper = new groupMapper('user');
        return $groupMapper->searchByUser($id);

    }

    public function getGroupsList($id)
    {
        $groups = $this->getGroups($id);
        $result = array();
        foreach ($groups as $group) {
            $result[] = $group->getId();
        }
        return $result;
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
        $map = $this->getMap();

        if (isset($this->map['password']['decorateClass'])) {
            $service = $this->map['password']['decorateClass'];
            fileLoader::load('service/' . $service);
            $service = new $service;
            $password = $service->apply($password);
        }

        $stmt = $this->db->prepare("SELECT * FROM `" . $this->table . "` WHERE `login` = :login AND `password` = :password");
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        $row = $stmt->fetch();

        $toolkit = systemToolkit::getInstance();
        $session = $toolkit->getSession();

        if ($row) {
            $session->set('user_id', $row['id']);
            $row = array(0 => array('user' => $row));
            return $this->createItemFromRow($row);
        } else {
            $session->set('user_id', MZZ_USER_GUEST_ID);
            return $this->getGuest();
        }
    }

    /**
     * ������� ������ user �� �������
     *
     * @param array $row
     * @return object
     */
    protected function createItemFromRow($row, $user = null)
    {
        if (empty($user)) {
            $map = $this->getMap();
            $user = new user($this, $map);
        }
        $row = $this->fill($row);
        $user->import($row);
        return $user;
    }

    /**
     * ���������� ������ ��� ����� (id = MZZ_USER_GUEST_ID)
     *
     * @return object
     */
    private function getGuest()
    {
        return $this->searchById(MZZ_USER_GUEST_ID);
    }

    /**
     * Magic method __sleep
     *
     * @return array
     */
    /*  public function __sleep()
    {
    return array('name', 'section', 'tablePostfix', 'cacheable', 'className', 'table');
    }*/

    /**
     * Magic method __wakeup
     *
     */
    /*public function __wakeup()
    {
    }*/
}

?>