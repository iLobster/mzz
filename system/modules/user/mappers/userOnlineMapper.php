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
 * userOnlineMapper
 *
 * @package modules
 * @subpackage user
 * @version 0.2
 */
class userOnlineMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'userOnline';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'user_userOnline';

    /**
     * Map
     *
     * @var array
     */
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

    protected function preInsert(& $data)
    {
        if (is_array($data)) {
            $data['last_activity'] = new sqlFunction('unix_timestamp');
        }
    }

    protected function preUpdate(& $data)
    {
        if (is_array($data)) {
            $data['last_activity'] = new sqlFunction('unix_timestamp');
        }
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
            $criteria->where('user_id', $me->getId());
            $criteria->where('session', $session->getId());
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
            $criteria->where('last_activity', new sqlOperator('-', array(new sqlFunction('unix_timestamp'), 15 * 60)), criteria::LESS);
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
        $criteria->where('user_id', $me->getId(), criteria::NOT_EQUAL);
        $criteria->where('session', $session->getId());
        $users = $this->searchAllbyCriteria($criteria);
        foreach ($users as $user) {
            $this->delete($user->getId());
        }

        $session->set('last_user_id', $me->getId());
    }
}

?>