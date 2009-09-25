<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('user/model/userOnline');

/**
 * userOnlineMapper: маппер
 *
 * @package modules
 * @subpackage user
 * @version 0.1.1
 */

class userOnlineMapper extends mapper
{

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'userOnline';
    protected $table = 'user_userOnline';

    protected $obj_id_field = null;

        protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'pk',
                'once')),
        'user_id' => array(
            'accessor' => 'getUser',
            'mutator' => 'setUser',
            'options' => array(
                'pk',
                'once')),
        'last_activity' => array(
            'accessor' => 'getLastActivity',
            'mutator' => 'setLastActivity'),
        'session' => array(
            'accessor' => 'getSession',
            'mutator' => 'setSession',
            'options' => array(
                'pk',
                'once')),
        'url' => array(
            'accessor' => 'getUrl',
            'mutator' => 'setUrl'),
        'ip' => array(
            'accessor' => 'getIp',
            'mutator' => 'setIp'),
    );

    /**
     * Выполнение операций с массивом $fields перед обновлением в БД
     *
     * @param array $fields
     */
    protected function updateDataModify(&$fields)
    {
        $fields['last_activity'] = new sqlFunction('unix_timestamp');
    }

    /**
     * Выполнение операций с массивом $fields перед вставкой в БД
     *
     * @param array $fields
     */
    protected function insertDataModify(&$fields)
    {
        $this->updateDataModify($fields);
    }

    /**
     * Обновление информации о пользователях онлайн
     * Запускается лишь один раз
     *
     * @param user $me
     */
    public function refresh($me)
    {
        static $alreadyRun = false;

        if (!$alreadyRun) {
            $toolkit = systemToolkit::getInstance();
            $session = $toolkit->getSession();
            $request = $toolkit->getRequest();

            $criteria = new criteria();
            $criteria->add('user_id', $me->getId());
            $criteria->add('session', $session->getId());
            $exists = $this->searchOneByCriteria($criteria);
            if (!$exists) {
                $exists = $this->create();
                $exists->setUser($me);
                $exists->setSession($session->getId());
                $exists->setIp($request->getServer('REMOTE_ADDR'));
            }
            $exists->setLastActivity('refresh please :)');
            $exists->setUrl($request->getRequestUrl());
            $this->save($exists);

            // удаляем по таймауту, а также пользователей, с такой же сессией но другим user_id (при смене логина)
            // @todo: таймаут переносить в конфиг
            $criteria = new criteria();
            $criteria->add('last_activity', new sqlOperator('-', array(new sqlFunction('unix_timestamp'), 15 * 60)), criteria::LESS);
            $users = $this->searchAllByCriteria($criteria);

            if (sizeof($users)) {
                $userMapper = $toolkit->getMapper('user', 'user', 'user');
            }

            foreach ($users as $user) {
                $this->delete($user->getId());

                $usr = $user->getUser();
                $usr->setLastLogin($user->getLastActivity());
                $userMapper->save($usr);
            }

            $last_id = $session->get('last_user_id');
            if ($last_id != $me->getId()) {
                $this->changeLogin($me, $session);
            }

            $alreadyRun = true;
        }
    }

    /**
     * Удаление старой записи при смене логина
     *
     * @param user $me
     * @param session $session
     */
    private function changeLogin($me, $session)
    {
        $session = systemToolkit::getInstance()->getSession();
        $criteria = new criteria();
        $criteria->add('user_id', $me->getId(), criteria::NOT_EQUAL);
        $criteria->add('session', $session->getId());
        $users = $this->searchAllbyCriteria($criteria);
        foreach ($users as $user) {
            $this->delete($user->getId());
        }

        $session->set('last_user_id', $me->getId());
    }

    /**
     * Возвращает уникальный для ДО идентификатор исходя из аргументов запроса
     *
     * @return integer
     */
    public function convertArgsToObj($args)
    {
        $obj = $this->create();
        $obj->import(array('obj_id' => 1));
        return $obj;
    }
}

?>