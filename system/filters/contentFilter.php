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

/**
 * contentFilter: фильтр получения и отображения контента
 *
 * @package system
 * @subpackage filters
 * @version 0.2.8
 */

class contentFilter implements iFilter
{
    /**
     * Префикс имени активного шаблона
     *
     */
    const TPL_PRE = "act/";

    /**
     * Расширение активного шаблона
     *
     */
    const TPL_EXT = ".tpl";

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
        $view = $toolkit->getView();

        $view->assign('toolkit', $toolkit);
        /*
        $view->assign('current_module', $request->getRequestedModule());
        $view->assign('current_action', $request->getRequestedAction());
        $view->assign('current_path', $request->getPath());
        $view->assign('current_lang', $toolkit->getLocale()->getName());
        $view->assign('current_user', $toolkit->getUser());
        $view->assign('available_langs', $toolkit->getLocale()->searchAll());
        */
        $request->setRequestedParams($request->getParams());

        try {
            $output = $this->runActiveTemplate($request, $toolkit, $view);
        } catch (mzzException $e) {
            if (DEBUG_MODE) {
                throw $e;
            }

            fileLoader::load('simple/simple404Controller');
            $controller = new simple404Controller();
            $output = $controller->run();
        }

        $response->append($output);

        $filter_chain->next();
    }

    public function runActiveTemplate($request, $toolkit, $view)
    {
        $module_name = $request->getModule();
        $action_name = $request->getAction();

        $tplPath = systemConfig::$pathToApplication . '/templates';

        $tpl_name = self::TPL_PRE . $module_name . '/' . $action_name . self::TPL_EXT;
        if (file_exists($tplPath . '/' . $tpl_name)) {
            return $view->render($tpl_name);
        }

        $module = $toolkit->getModule($module_name);
        $action = $module->getAction($action_name);

        $activeTemplate = $action->getActiveTemplate();

        if ($activeTemplate == 'deny') {
            throw new mzzNoActionException('Direct access to this action is deny');
        }

        $view->assign('module', $module_name);
        $view->assign('action', $action_name);

        return $view->render($activeTemplate, 'smarty');
    }
}

?>