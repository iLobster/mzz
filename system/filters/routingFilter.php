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

        $cache = $toolkit->getCache('long');

        if (!$cache->get('routes', $routes)) {
            $routes = array(
                'first' => array(),
                'last' => array());
            $adminMapper = $toolkit->getMapper('admin', 'admin');
            foreach ($adminMapper->getModules() as $module) {
                if ($moduleRoutes = $module->getRoutes()) {
                    $routes['first'] += $moduleRoutes[0];
                    $routes['last'] += $moduleRoutes[1];
                }
            }

            $cache->set('routes', $routes);
        }

        $filePath = fileLoader::resolve('routes/default_last');

        if ($filePath === false) {
            throw new mzzIoException('routes/default_last');
        } else {
            require_once $filePath;
        }

        foreach ($routes['last'] as $name => $route) {
            $router->addRoute($name, $route);
        }

        $filePath = fileLoader::resolve('routes/default_first');

        if ($filePath === false) {
            throw new mzzIoException('routes/default_first');
        } else {
            require_once $filePath;
        }

        foreach ($routes['first'] as $name => $route) {
            $router->addRoute($name, $route);
        }

        $filePath = fileLoader::resolve('routes/default');

        if ($filePath === false) {
            throw new mzzIoException('routes/default');
        } else {
            require_once $filePath;
        }

        try {
            $router->route($request->getPath());
        } catch (mzzRuntimeException $e) {
            if (DEBUG_MODE) {
                throw $e;
            }

            $router->route(systemConfig::$uri404);
        }

        $filter_chain->next();
    }
}

?>