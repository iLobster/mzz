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
 * TimingFilter: ������ ��� �������� ������� ���������� �������
 *
 * @package system
 * @version 0.1
 */

class TimingFilter
{
    /**
     * ������ ������� �� ����������
     *
     * @param filterChain $filter_chain ������, ���������� ������� ��������
     * @param response $response ������, ���������� ����������, ��������� ������� � �������
     */
    public function run($filter_chain, $response)
    {
        $start_time = microtime(true);

        $filter_chain->next();

        $registry = Registry::instance();
        $smarty = $registry->getEntry('smarty');
        $smarty->assign('time', (microtime(true) - $start_time));

        $db = DB::factory();
        $smarty->assign('queries_num', $db->getQueriesNum());
        $smarty->assign('queries_time', $db->getQueriesTime());
        $response->append($smarty->fetch('filter.time.tpl'));

    }
}

?>