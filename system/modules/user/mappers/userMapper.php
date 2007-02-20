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
 * @package modules
 * @subpackage user
 * @version 0.2
 */

fileLoader::load('user');

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
            $session->set('user_id', $user->getId());
            return $user;
        } else {
            $session->set('user_id', MZZ_USER_GUEST_ID);
            return $this->getGuest();
        }
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

    public function convertArgsToId($args)
    {
        if (isset($args['id'])) {
            if ($args['id'] == 0) {
                $toolkit = systemToolkit::getInstance();
                $user = $toolkit->getUser();
            } else {
                $user = $this->searchById($args['id']);
            }
            if ($user) {
                return (int)$user->getObjId();
            }

            throw new mzzDONotFoundException();
        }

        $toolkit = systemToolkit::getInstance();
        $obj_id = $toolkit->getObjectId($this->section . '_userFolder');
        $this->register($obj_id);
        return $obj_id;


        /*elseif (isset($args[0])) {
        $user = $this->searchById($args[0]);
        return (int)$user->getObjId();
        }*/

        /*
        $toolkit = systemToolkit::getInstance();
        $user = $toolkit->getUser();
        return $user->getObjId();*/
        /*
        var_dump($args);
        $user = $this->searchOneByField('id', $args[0]);
        return (int)$user->getObjId();*/
    }
}

?>