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

fileLoader::load('user/userAuth');

/**
 * userAuthMapper: маппер
 *
 * @package modules
 * @subpackage user
 * @version 0.1.1
 */

class userAuthMapper extends simpleMapper
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
    protected $className = 'userAuth';

    protected $obj_id_field = null;

    protected $toolkit;
    protected $request;
    protected $session;

    public function __construct($section)
    {
        parent::__construct($section);
        $this->toolkit = systemToolkit::getInstance();
        $this->request = $this->toolkit->getRequest();
        $this->session = $this->toolkit->getSession();
    }

    public function get()
    {
        $hash = $this->getHash();
        $ip = $this->getIp();

        $criteria = new criteria();
        $criteria->add('hash', $hash)->add('ip', $ip);

        $auth = $this->searchOneByCriteria($criteria);

        if ($auth) {
            $auth->setTime('update me please');
            $this->save($auth);
        }

        return $auth;
    }

    public function set($user_id)
    {
        $hash = $this->getHash();
        $ip = $this->getIp();

        $userAuth = $this->get();

        if (is_null($userAuth)) {
            $userAuth = $this->create();
            $userAuth->setIp($ip);
        }

        $userAuth->setHash($hash = md5(microtime(true)));
        $userAuth->setUserId($user_id);

        $response = $this->toolkit->getResponse();
        $response->setCookie('auth', $hash, time() + 10 * 365 * 86400, '/');

        $this->save($userAuth);

        return $userAuth;
    }

    public function clear()
    {
        $hash = $this->getHash();
        $userAuth = $this->searchAllByField('hash', $hash);

        foreach ($userAuth as $each) {
            $this->delete($each->getId());
        }

        $response = $this->toolkit->getResponse();
        $response->setCookie('auth', '', 0, '/');
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

    private function getHash()
    {
        return $this->request->get('auth', 'string', SC_COOKIE);
    }

    private function getIp()
    {
        return $this->request->get('REMOTE_ADDR', 'string', SC_SERVER);
    }

    /**
     * Выполнение операций с массивом $fields перед вставкой в БД
     *
     * @param array $fields
     */
    protected function insertDataModify(&$fields)
    {
        $fields['time'] = time();
    }

    /**
     * Выполнение операций с массивом $fields перед обновлением в БД
     *
     * @param array $fields
     */
    protected function updateDataModify(&$fields)
    {
        $this->insertDataModify($fields);
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