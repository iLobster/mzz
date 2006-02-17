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
 * contentFilter: ������ ��������� � ����������� ��������
 *
 * @package system
 * @version 0.2
 */

class contentFilter implements iFilter
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

        $frontcontroller = new frontController($request);
        $template = $frontcontroller->getTemplate();

        $smarty = $toolkit->getSmarty();
        $response->append($smarty->fetch($template));

        $filter_chain->next();
    }
}

?>