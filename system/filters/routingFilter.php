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
 * routingFilter: фильтр, в котором происходит процесс роутинга
 *
 * @package system
 * @subpackage filters
 * @version 0.1
 */
class routingFilter implements iFilter
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

        $router = $toolkit->getRouter($request);

        require_once fileLoader::resolve('configs/routes');

        try {
            $router->route($request->getPath());
        } catch (mzzRuntimeException $e) {
            if (DEBUG_MODE) {
                throw $e;
            }
        }

        $filter_chain->next();
    }
}

?>