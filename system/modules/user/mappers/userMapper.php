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
 * @package user
 * @version 0.2
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
     * Массив кешируемых методов
     *
     * @var array
     */
    //  protected $cacheable = array('searchById', 'searchByLogin');

    /**
     * Конструктор
     *
     * @param string $section секция
     */
    public function __construct($section)
    {
        parent::__construct($section);
        $this->relationTable = $this->table . '_group_rel';
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
        $stmt = $this->searchByField('id', $id);
        $row = $stmt->fetch();

        if ($row) {
            return $this->createUserFromRow($row);
        } else {
            if($id === 1) {
                throw new mzzSystemException('Отсутствует запись с ID: 1 для гостя в таблице ' . $this->table);
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
        $stmt = $this->searchByField('login', $login);
        $row = $stmt->fetch();

        if ($row) {
            return $this->createUserFromRow($row);
        } else {
            return $this->getGuest();
        }
    }

    public function getGroups($id)
    {
        $groupMapper = new groupMapper('user');
        return $groupMapper->searchByUser($id);

    }

    public function getGroupsList()
    {

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
            return $this->createUserFromRow($row);
        } else {
            $session->set('user_id', 1);
            return $this->getGuest();
        }
    }

    /**
     * Создает объект user из массива
     *
     * @param array $row
     * @return object
     */
    protected function createUserFromRow($row)
    {
        $map = $this->getMap();
        $user = new user($this, $map);
        $user->import($row);
        return $user;
    }

    /**
     * Возвращает объект для гостя (id = 1)
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