<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2005
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

/**
 * timingFilter: ������ ��� ��������
 * 
 * @package system
 * @version 0.1
 */

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
        $start_time = microtime(true);

        $filter_chain->next();
        $smarty = mzzSmarty::getInstance();
        $smarty->assign('time', (microtime(true) - $start_time));
        $response->append($smarty->fetch('filter.time.tpl'));
        
    }
}

?>