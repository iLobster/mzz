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

class timingFilter
{
    /**
     * ������ ������� �� ����������
     *
     * @param filterChain $filter_chain ������, ���������� ������� ��������
     * @param response $response ������, ���������� ����������, ��������� ������� � �������
     */
    public function run($filter_chain, $response)
    {
        $timer = new timer();
        $timer->start();

        $registry = Registry::instance();
        $registry->setEntry('sysTimer', $timer);

        $filter_chain->next();

        $timer->finish();
    }
}

?>