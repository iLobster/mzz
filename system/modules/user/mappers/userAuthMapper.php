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

/**
 * userAuthMapper: ������
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

fileLoader::load('user/userAuth');

class userAuthMapper extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'user';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'userAuth';

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

        return $this->searchOneByCriteria($criteria);
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

    private function getHash()
    {
        return $this->request->get('auth', 'string', SC_COOKIE);
    }

    private function getIp()
    {
        return $this->request->get('REMOTE_ADDR', 'string', SC_SERVER);
    }

    /**
     * ���������� �������� � �������� $fields ����� �������� � ��
     *
     * @param array $fields
     */
    protected function insertDataModify(&$fields)
    {
        $fields['time'] = time();
    }

    /**
     * ���������� �������� � �������� $fields ����� ����������� � ��
     *
     * @param array $fields
     */
    protected function updateDataModify(&$fields)
    {
        $fields['time'] = new sqlFunction('UNIX_TIMESTAMP');
    }


    /**
     * ���������� ���������� ��� �� ������������� ������ �� ���������� �������
     *
     * @return object
     */
    public function convertArgsToId($args)
    {

    }
}

?>