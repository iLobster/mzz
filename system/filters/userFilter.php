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
 * userFilter: ������ ��� ������������� �������� ������������
 *
 * @package system
 * @version 0.1
 */

fileLoader::load('user');
fileLoader::load("user/mappers/userMapper");

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

        $user_id = $session->get('user_id', 1);

        // ��... �������� �������� �� �����??
        $userMapper = new cache(new userMapper('user'), systemConfig::$pathToTemp . '/cache');

        $me = $userMapper->searchById($user_id);

        $toolkit->setUser($me);

        $filter_chain->next();
    }
}

?>