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
 * userMapper: маппер для пользователей
 *
 * @package modules
 * @subpackage user
 * @version 0.2
 */

fileLoader::load('user');

class userMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'user';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'user';


    /**
     * Создает пустой объект DO
     *
     * @return object
     */
    public function create()
    {
        return new user($this, $this->getMap());
    }

    /**
     * Выполняет поиск объекта по идентификатору
     *
     * @param integer $id идентификатор
     * @return object
     */
    public function searchById($id)
    {
        $user = $this->searchOneByField('id', $id);

        if ($user) {
            return $user;
        } else {
            if($id === MZZ_USER_GUEST_ID) {
                throw new mzzSystemException('Отсутствует запись с ID: ' . MZZ_USER_GUEST_ID . ' для гостя в таблице ' . $this->table);
            }
            return $this->getGuest();
        }
    }

    /**
     * Выполняет поиск объекта по логину
     *
     * @param string $login логин
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
     * Возвращает список групп, в которых существует
     * пользователь с идентификатором $id
     *
     * @param string $id идентификатором
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
     * Идентифицирует пользователя по логину и паролю и
     * в случае успеха устанавливает сессию
     * идентифицированного пользователя
     *
     * @param string $login логин
     * @param string $password пароль
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
     * Возвращает объект для гостя (id = MZZ_USER_GUEST_ID)
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