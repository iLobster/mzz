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
 * ContentFilter: ������ ��������� � ����������� ��������
 *
 * @package system
 * @version 0.1
 */

class ContentFilter
{
    /**
     * ������ ������� �� ����������
     *
     * @param filterChain $filter_chain ������, ���������� ������� ��������
     * @param response $response ������, ���������� ����������, ��������� ������� � �������
     */
    public function run($filter_chain, $response)
    {
        $registry = Registry::instance();
        $httprequest = $registry->getEntry('httprequest');

        $application = $httprequest->getSection();
        $action = $httprequest->getAction();

        $frontcontroller = new frontController($application, $action);
        $template = $frontcontroller->getTemplate();

        $smarty = $registry->getEntry('smarty');
        $response->append($smarty->fetch($template));

        $filter_chain->next();
    }
}

?>