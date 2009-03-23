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
class userMapper extends mapper
{
    /**
     * Учётная запись не подтверждена
     *
     */
    const NOT_CONFIRMED = -1;

    /**
     * Неверные аутентификационные данные
     *
     */
    const WRONG_AUTH_DATA = 0;

    /**
     * Имя таблицы
     *
     * @var string
     */
    protected $table = 'user_user';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'user';

    public $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'pk')),
        'login' => array(
            'accessor' => 'getLogin',
            'mutator' => 'setLogin'),
        'password' => array(
            'accessor' => 'getPassword',
            'mutator' => 'setPassword'),
        'created' => array(
            'accessor' => 'getCreated',
            'mutator' => 'setCreated'),
        'confirmed' => array(
            'accessor' => 'getConfirmed',
            'mutator' => 'setConfirmed'),
        'last_login' => array(
            'accessor' => 'getLastLogin',
            'mutator' => 'setLastLogin'),
        'language_id' => array(
            'accessor' => 'getLanguageId',
            'mutator' => 'setLanguageId'),
        'timezone' => array(
            'accessor' => 'getTimezone',
            'mutator' => 'setTimezone'),
        'skin' => array(
            'accessor' => 'getSkin',
            'mutator' => 'setSkin'),
        'groups' => array(
            'accessor' => 'getGroups',
            'mutator' => 'setGroups',
            'relation' => 'many-to-many',
            'mapper' => 'user/groupMapper',
            'reference' => 'user_userGroup_rel',
            'local_key' => 'id',
            'foreign_key' => 'id',
            'ref_local_key' => 'user_id',
            'ref_foreign_key' => 'group_id'));

    /**
     * Выполняет поиск объекта по логину
     *
     * @param string $login логин
     * @return object
     */
    public function searchByLogin($login)
    {
        return $this->searchOneByField('login', $login);
    }

    /**
     * Выполняет поиск объекта по email
     *
     * @param string $email
     * @return object
     */
    public function searchByEmail($email)
    {
        return $user = $this->searchOneByField('email', $email);
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
        return systemToolkit::getInstance()->getMapper('user', 'userGroup')->searchGroupsIdsByUser($id);
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
        $criteria = new criteria();
        $criteria->add($loginField, $login)->add('password', $this->cryptPassword($password));

        $user = $this->searchOneByCriteria($criteria);

        if ($user && $user->isConfirmed()) {
            return $user;
        } else {
            return $user ? self::NOT_CONFIRMED : self::WRONG_AUTH_DATA;
        }
    }

    /**
     * Возвращает объект для гостя (id = MZZ_USER_GUEST_ID)
     *
     * @return object
     */
    public function getGuest()
    {
        return $this->searchByKey(MZZ_USER_GUEST_ID);
    }

    protected function preInsert(& $data)
    {
        if (is_array($data)) {
            $data['created'] = time();
            if (isset($data['password'])) {
                $data['password'] = $this->cryptPassword($data['password']);
            }
        }
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

    public function updateLastLoginTime($user)
    {
        $user->setLastLogin(new sqlFunction('unix_timestamp'));
        $this->save($user);
    }

    protected function cryptPassword($password)
    {
        return md5($password);
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