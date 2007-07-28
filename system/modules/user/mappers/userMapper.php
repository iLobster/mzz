<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('user');

/**
 * userMapper: ������ ��� �������������
 *
 * @package modules
 * @subpackage user
 * @version 0.2.2
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
        $user = $this->searchOneByField('id', $id);

        if ($user) {
            return $user;
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
        $user = $this->searchOneByField('login', $login);

        if ($user) {
            return $user;
        } else {
            return $this->getGuest();
        }
    }

    /**
     * ���������� ������ �����, � ������� ����������
     * ������������ � ��������������� $id
     *
     * @param string $id ���������������
     * @return array
     */
    public function getGroupsList($id)
    {
        $user = $this->searchById($id);
        $groups = $user->getGroups();
        $result = array();
        foreach ($groups as $group) {
            $result[] = $group->getGroup()->getId();
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

        if (isset($map['password']['decorateClass'])) {
            $service = $map['password']['decorateClass'];
            fileLoader::load('service/' . $service);
            $service = new $service;
            $password = $service->apply($password);
        }

        $criteria = new criteria();
        $criteria->add('login', $login)->add('password', $password);

        $user = $this->searchOneByCriteria($criteria);

        $toolkit = systemToolkit::getInstance();
        $session = $toolkit->getSession();

        if ($user) {
            $this->setUserId($user->getId());
        } else {
            $this->setUserId(MZZ_USER_GUEST_ID);
            $user = $this->getGuest();
        }

        return $user;
    }

    /**
     * ��������� �������� user_id
     *
     * @param integer $user_id
     */
    public function setUserId($user_id)
    {
        $toolkit = systemToolkit::getInstance();
        $session = $toolkit->getSession();
        $session->set('user_id', $user_id);
    }

    /**
     * ��������� �������� user_id
     *
     * @return integer
     */
    public function getUserId()
    {
        $toolkit = systemToolkit::getInstance();
        $session = $toolkit->getSession();
        return $session->get('user_id');
    }

    /**
     * ������ ������������
     *
     */
    public function logout()
    {
        $this->setUserId(MZZ_USER_GUEST_ID);
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

    public function convertArgsToObj($args)
    {
        if (isset($args['id'])) {
            if ($args['id'] == 0) {
                $toolkit = systemToolkit::getInstance();
                $user = $toolkit->getUser();
            } else {
                $user = $this->searchById($args['id']);
            }
            if ($user) {
                return $user;
            }

            throw new mzzDONotFoundException();
        }

        $toolkit = systemToolkit::getInstance();
        $obj_id = $toolkit->getObjectId($this->section . '_userFolder');
        $this->register($obj_id);

        $user = $this->create();
        $user->import(array('obj_id' => $obj_id));

        return $user;
    }
}

?>