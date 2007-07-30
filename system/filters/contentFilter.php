<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * contentFilter: ������ ��������� � ����������� ��������
 *
 * @package system
 * @subpackage filters
 * @version 0.2.6
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

        $tplPath = systemConfig::$pathToApplication . '/templates';
        $frontcontroller = new frontController($request, $tplPath);

        $router = $toolkit->getRouter($request);

        require_once fileLoader::resolve('configs/routes');

        try {
            $router->route($request->getPath());
        } catch (mzzRouteException $e) {
            if ($e->getMessage() == 404) {
                $this->set404($request);
            }
        }

        try {
            $template = $frontcontroller->getTemplateName();
        } catch (mzzRuntimeException $e) {
            if (DEBUG_MODE) {
                throw $e;
            }

            $output = $this->get404($request);
            if ($output === false) {
                $template = $frontcontroller->getTemplateName();
            }
        }

        $smarty = $toolkit->getSmarty();
        // @todo �������� ����� �� � ������� ������ ��� ����������
        //��������: ������� �����. ��� ��� ���? � ����������� {url ������������ section=$current_section. �� ��������� ������ �������� ������ $request � ������.
        $smarty->assign('current_section', $request->getRequestedSection());
        $smarty->assign('current_action', $request->getRequestedAction());
        $smarty->assign('current_path', $request->getPath());

        // ���� ������ ��� �� ���� (�� 404 ��������), ��� ��� (404, �� ��������� false - ��� ������ ��� ������ ���� ������� ����������� ������ ����� �������� ������)
        if (!isset($output) || $output === false) {
            $output = $smarty->fetch($template);
        }

        $response->append($output);

        $filter_chain->next();
    }

    /**
     * ����� �������� 404
     *
     */
    private function get404()
    {
        fileLoader::load('simple/simple404Controller');
        $controller = new simple404Controller(true);
        return $controller->run();
    }
}

?>