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
 * userMapper: маппер для пользователей
 *
 * @package modules
 * @subpackage user
 * @version 0.2.2
 */
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
     * @param string $loginField имя поля, которое используется в качестве логина
     * @return object
     */
    public function login($login, $password, $loginField = 'login')
    {
        $map = $this->getMap();

        if (isset($map['password']['decorateClass'])) {
            $service = $map['password']['decorateClass'];
            fileLoader::load('service/' . $service);
            $service = new $service;
            $password = $service->apply($password);
        }

        $criteria = new criteria();
        $criteria->add($loginField, $login)->add('password', $password);

        $user = $this->searchOneByCriteria($criteria);

        if ($user && $user->isConfirmed()) {
            $this->setUserId($user->getId());
        } else {
            $this->setUserId(MZZ_USER_GUEST_ID);
            $user = $this->getGuest();
        }

        return $user;
    }

    /**
     * Установка текущего user_id
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
     * Получение текущего user_id
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
     * Логаут пользователя
     *
     */
    public function logout()
    {
        $this->setUserId(MZZ_USER_GUEST_ID);
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