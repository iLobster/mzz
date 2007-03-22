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
 * contentFilter: фильтр получения и отображения контента
 *
 * @package system
 * @subpackage filters
 * @version 0.2.3
 */
class contentFilter implements iFilter
{
    /**
     * запуск фильтра на исполнение
     *
     * @param filterChain $filter_chain объект, содержащий цепочку фильтров
     * @param httpResponse $response объект, содержащий информацию, выводимую клиенту в браузер
     * @param iRequest $request
     */
    public function run(filterChain $filter_chain, $response, iRequest $request)
    {
                require_once '../../umi-stat/www/init.php';
        require_once '../../umi-stat/www/classes/statistic.php';
        $stat = new statistic();
        $stat->event(mt_rand(1, 10));
        //$stat->doLogin();
        $stat->run();

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
            $this->set404($request);
            $template = $frontcontroller->getTemplateName();
        }

        $smarty = $toolkit->getSmarty();
        $smarty->assign('current_section', $request->getSection());
        $output = $smarty->fetch($template);

        $response->append($output);

        $filter_chain->next();
    }

    /**
     * Установка в request значений параметров, необходимых для отображения страницы с ошибкой 404
     *
     * @param httpRequest $request
     */
    private function set404($request)
    {
        $request->setSection('page');
        $request->setAction('view');
        $request->setParams(array('name' => 404));
    }
}

?>