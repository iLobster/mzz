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

fileLoader::load('core/loadDispatcher');
fileLoader::load('filters/aContentFilter');


/**
 * contentFilter: фильтр получения и отображения контента
 *
 * @package system
 * @subpackage filters
 * @version 0.2.10
 */
class contentFilter extends abstractContentFilter  implements iFilter
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
        $params = $request->getParams();
        $toolkit = systemToolkit::getInstance();
        $module_name = $request->getModule();
        $action_name = $request->getAction();
        $request->setRequestedParams($params);
        $cache = $toolkit->getCache();
        $user = $toolkit->getUser();

        // Example how show cached content in news module for guests
        // Dont forget flush cache after changes in page content!
        $cached_actions = array('view');
        $show_from_cache = !$user->isLoggedIn() && $module_name == 'news' && in_array($action_name, $cached_actions);

        if ($show_from_cache) {
            $page = (int)$request->getInteger('page', SC_GET);
            $cache_params = array($module_name, $action_name);
            $cache_params = array_merge($cache_params, $params);
            $cache_params[] = $page;
            $identifier = implode('-', $cache_params);

            // guests use content from cache
            if (!$cache->get($identifier, $output)) {
                // do render if cache is empty
                $output = $this->renderPage($response, $request);
                // do not cache 404 page
                if (!mzz_strpos($page, '404 Not Found')) {
                    $cache->set($identifier, $output);
                }
            }
        } else {
            $output = $this->renderPage($response, $request);
        }


        $response->append($output);
        $filter_chain->next();
    }

    /**
     * do changes in output after render page
     *
     * @param string $output
     */
    protected  function afterRenderPage(&$output)
    {

    }

}

?>