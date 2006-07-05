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
 * @package system
 * @subpackage filters
 * @version $Id$
*/

fileLoader::load('user');
fileLoader::load("user/mappers/userMapper");

/**
 * userFilter: ������ ��� ������������� �������� ������������
 *
 * @package system
 * @subpackage filters
 * @version 0.1
 */
class userFilter implements iFilter
{
    /**
     * ������ ������� �� ����������
     *
     * @param filterChain $filter_chain ������, ���������� ������� ��������
     * @param httpResponse $response ������, ���������� ����������, ��������� ������� � �������
     * @param iRequest $request
     */
    public function run(filterChain $filter_chain, $response, iRequest $request)
    {
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();
        $session = $toolkit->getSession();

        $user_id = $session->get('user_id', MZZ_USER_GUEST_ID);

        // ��... �������� �������� �� �����??
        //$userMapper = $toolkit->getCache(new userMapper('user'));
        $userMapper = new userMapper('user');

        $me = $userMapper->searchById($user_id);

        $toolkit->setUser($me);

        $filter_chain->next();
    }
}

?>