<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('user/model/userAuth');

/**
 * userAuthMapper: маппер
 *
 * @package modules
 * @subpackage user
 * @version 0.1.2
 */

class userAuthMapper extends mapper
{
    const AUTH_COOKIE_NAME = 'auth';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'userAuth';
    protected $table = 'user_userAuth';

    public $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array('once','pk')
        ),
        'hash' => array(
            'accessor' => 'getHash',
            'mutator' => 'setHash',
            'options' => array('once')
        ),
        'ip' => array(
            'accessor' => 'getIp',
            'mutator' => 'setIp',
            'options' => array('once')
        ),
        'user_id' => array(
            'accessor' => 'getUser',
            'mutator' => 'setUser',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'user/user',
            'join_type' => 'inner',
            'options' => array('once')
        ),
        'time' => array(
            'accessor' => 'getTime',
            'mutator' => 'setTime',
        ),
    );

    public function getAuth($hash, $ip)
    {
        $criteria = new criteria();
        $criteria->add('hash', $hash)->add('ip', $ip);

        $auth = $this->searchOneByCriteria($criteria);

        if ($auth) {
            $this->save($auth);
        }

        return $auth;
    }

    public function saveAuth($user, $hash, $ip)
    {
        $userAuth = $this->getAuth($hash, $ip);

        if (!is_null($userAuth) && $user_id != $userAuth->getUserId()) {
            $userAuth = null;
        }

        if (is_null($userAuth)) {
            $userAuth = $this->create();
            $userAuth->setIp($ip);
            $userAuth->setUser($user);
            $this->save($userAuth);
        }

        return $userAuth;
    }

    public function clear($hash)
    {
        $userAuthCollection = $this->searchAllByField('hash', $hash);

        foreach ($userAuthCollection as $userAuth) {
            $this->delete($userAuth->getId());
        }
    }

    public function clearExpired($timestamp)
    {
        $criteria = new criteria();
        $criteria->add('time', $timestamp, criteria::LESS);

        $auths = $this->searchAllByCriteria($criteria);

        foreach ($auths as $auth) {
            $this->delete($auth);
        }
    }

    protected function preInsert(& $data)
    {
        if (is_array($data)) {
            $data['time'] = time();
            $data['hash'] = md5(microtime(true));
        }
    }

    /**
     * Возвращает уникальный для ДО идентификатор исходя из аргументов запроса
     *
     * @return object
     */
    public function convertArgsToObj($args)
    {

    }
}

?>