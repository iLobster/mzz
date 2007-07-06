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

fileLoader::load('user/userOnline');

/**
 * userOnlineMapper: маппер
 *
 * @package modules
 * @subpackage user
 * @version 0.1.1
 */

class userOnlineMapper extends simpleMapper
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
    protected $className = 'userOnline';

    /**
     * Выполнение операций с массивом $fields перед обновлением в БД
     *
     * @param array $fields
     */
    protected function updateDataModify(&$fields)
    {
        $fields['last_activity'] = new sqlFunction('NOW');
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
                $exists->setIp($request->get('REMOTE_ADDR', 'string', SC_SERVER));
            }
            $exists->setLastActivity('refresh please :)');
            $exists->setUrl($request->getRequestUrl());
            $this->save($exists);

            // удаляем по таймауту, а также пользователей, с такой же сессией но другим user_id (при смене логина)
            // @todo: таймаут переносить в конфиг
            $criteria = new criteria();
            $criteria->add('last_activity', new sqlOperator('-', array(new sqlFunction('NOW'), new sqlOperator('INTERVAL', array('15 MINUTE')))), criteria::LESS);
            $users = $this->searchAllbyCriteria($criteria);
            foreach ($users as $user) {
                $this->delete($user->getId());
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
    public function convertArgsToId($args)
    {
        return 1;
    }
}

?>