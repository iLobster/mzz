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
 * contentFilter: фильтр получения и отображения контента
 *
 * @package system
 * @subpackage filters
 * @version 0.2
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

        $frontcontroller = new frontController($request);

        $router = $toolkit->getRouter($request);

        require_once fileLoader::resolve('configs/routes');

        try {
            $router->route($request->getPath());
        } catch (mzzRouteException $e) {
            if ($e->getMessage() == 404) {
                $request->setSection('page');
                $request->setAction('view');
                $request->setParams(array('name' => 404));
            }
        } catch (Exception $e) {
            throw $e;
        }

        $template = $frontcontroller->getTemplate();

        $smarty = $toolkit->getSmarty();
        $smarty->assign('current_section', $request->getSection());
        $response->append($smarty->fetch($template));

        $filter_chain->next();
    }
}

?>