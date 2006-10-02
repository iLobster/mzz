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
fileLoader::load('user/mappers/groupMapper');

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
     * Конструктор
     *
     * @param string $section секция
     */
    public function __construct($section)
    {
        parent::__construct($section);
    }

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
     * Идентифицирует пользователя по логину и паролю и
     * в случае успеха устанавливает сессию
     * идентифицированного пользователя
     *
     * @todo переписать запрос с генератором
     * @param string $login логин
     * @param string $password пароль
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
            return $this->createItemFromRow($row);
        } else {
            $session->set('user_id', MZZ_USER_GUEST_ID);
            return $this->getGuest();
        }
    }

    /**
     * Создает объект user из массива
     *
     * @param array $row
     * @return object
     */
    protected function createItemFromRow($row)
    {
        $user = new user($this, $this->getMap());
        $user->import($row);
        return $user;
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
}

?>