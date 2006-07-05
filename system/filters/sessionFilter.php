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
 * sessionFilter: ������ ��� ������ ������
 *
 * @package system
 * @subpackage filters
 * @version 0.2
 */

fileLoader::load('session');

class sessionFilter implements iFilter
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
        /*
        $toolkit = systemToolkit::getInstance();
        �������� ������ ����� ���������� �� �������
        */
        $session = new session;
        $session->start();

        $filter_chain->next();

        //$session->stop(); ??
    }
}

?>