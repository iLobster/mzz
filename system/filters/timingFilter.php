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
 * timingFilter: ������ ��� �������� ������� ���������� �������
 *
 * @package system
 * @version 0.1.1
 */

fileLoader::load('timer/timer');

class timingFilter implements iFilter
{
    /**
     * ������ ������� �� ����������
     *
     * @param filterChain $filter_chain ������, ���������� ������� ��������
     * @param response $response ������, ���������� ����������, ��������� ������� � �������
     */
    public function run(filterChain $filter_chain, $response, $request)
    {
        $toolkit = systemToolkit::getInstance();
        $toolkit->getTimer();

        $filter_chain->next();
    }
}

?>