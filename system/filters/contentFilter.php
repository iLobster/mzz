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
 * @subpackage filters
 * @version 0.2
 */
class contentFilter implements iFilter
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

        $frontcontroller = new frontController($request);

        $router = $toolkit->getRouter($request);

        require_once fileLoader::resolve('configs/routes');

        $router->route($request->getPath());

        $template = $frontcontroller->getTemplate();

        $smarty = $toolkit->getSmarty();
        $smarty->assign('current_section', $request->getSection());
        $response->append($smarty->fetch($template));

        $filter_chain->next();
    }
}

?>