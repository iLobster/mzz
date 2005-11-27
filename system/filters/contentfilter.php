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
 * contentFilter: ������ ��������� � ����������� ��������
 *
 * @package system
 * @version 0.1
 */

class contentFilter
{
    /**
     * ������ ������� �� ����������
     *
     * @param filterChain $filter_chain ������, ���������� ������� ��������
     * @param response $response ������, ���������� ����������, ��������� ������� � �������
     */
    public function run($filter_chain, $response)
    {
        $httprequest = HttpRequest::getInstance();

        $application = $httprequest->getSection();
        $action = $httprequest->getAction();

        $frontcontroller = new frontController($application, $action);
        $template = $frontcontroller->getTemplate();

        $smarty = mzzSmarty::getInstance();
        $response->append($smarty->fetch($template));

        $filter_chain->next();
    }
}

?>