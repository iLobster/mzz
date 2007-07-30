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
 * @version 0.2.6
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
        // @todo подумать нужны ли в шаблоне теперь эти переменные
        //страйкер: конечно нужны. как без них? в большинстве {url используется section=$current_section. Но предлагаю просто передать объект $request в смарти.
        $smarty->assign('current_section', $request->getRequestedSection());
        $smarty->assign('current_action', $request->getRequestedAction());
        $smarty->assign('current_path', $request->getPath());

        // если вывода ещё не было (не 404 страница), или был (404, но вернувшая false - что значит что должен быть запущен стандартный запуск через активный шаблон)
        if (!isset($output) || $output === false) {
            $output = $smarty->fetch($template);
        }

        $response->append($output);

        $filter_chain->next();
    }

    /**
     * Вывод страницы 404
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