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
 * @version 0.2.3
 */
class userMapper extends simpleMapper
{
    /**
     * Учётная запись не подтверждена
     *
     */
    const NOT_CONFIRMED = 1;

    /**
     * Неверные аутентификационные данные
     *
     */
    const WRONG_AUTH_DATA = 2;

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
     * Причина неудачной авторизации
     *
     * @var unknown_type
     */
    protected $reason;

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
     * Выполняет поиск объекта по email
     *
     * @param string $email
     * @return object
     */
    public function searchByEmail($email)
    {
        $user = $this->searchOneByField('email', $email);

        if ($user) {
            return $user;
        } else {
            return $this->getGuest();
        }
    }

    public function getOnline($id)
    {
        $userOnlineMapper = systemToolkit::getInstance()->getMapper('user', 'userOnline', $this->section);
        return $userOnlineMapper->searchOneByField('user_id', $id);
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
        $userRel = systemToolkit::getInstance()->getMapper('user', 'userGroup', $this->section);
        return $userRel->searchGroupsIdsByUser($id);
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
            $this->reason = $user ? self::NOT_CONFIRMED : self::WRONG_AUTH_DATA;

            $this->setUserId(MZZ_USER_GUEST_ID);
            $user = $this->getGuest();
        }

        return $user;
    }

    /**
     * Получение причины неудачной авторизации
     *
     * @return integer
     */
    public function getReason()
    {
        return $this->reason;
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

    protected function insertDataModify(&$fields)
    {
        $fields['created'] = time();
    }

    public function delete($id)
    {
        if ($id instanceof user) {
            $id = $id->getId();
        } elseif (!is_scalar($id)) {
            throw new mzzRuntimeException('Wrong id or object');
        }

        // исключаем пользователя из групп, в которых он состоял
        $userGroupMapper = systemToolkit::getInstance()->getMapper('user', 'userGroup', $this->section);
        $groups = $userGroupMapper->searchAllByField('user_id', $id);

        foreach ($groups as $val) {
            $userGroupMapper->delete($val->getId());
        }

        parent::delete($id);
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
        }

        throw new mzzDONotFoundException();
    }
}

?>