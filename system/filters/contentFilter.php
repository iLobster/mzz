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
        $smarty = $toolkit->getSmarty();

        $tplPath = systemConfig::$pathToApplication . '/templates';

        $template = $this->getTemplateName($request, $tplPath, $toolkit);

        $smarty->assign('current_module', $request->getRequestedModule());
        $smarty->assign('current_action', $request->getRequestedAction());
        $smarty->assign('current_path', $request->getPath());
        $smarty->assign('current_lang', $toolkit->getLocale()->getName());
        $smarty->assign('current_user', $toolkit->getUser());
        $smarty->assign('available_langs', $toolkit->getLocale()->searchAll());
        $request->setRequestedParams($request->getParams());

        if ($template === false) {
            try {
                $output = $this->runActiveTemplate($request, $toolkit, $smarty);
            } catch (mzzException $e) {
                // the only one way to catch this exception - is to call the action with "deny" active template
                if (DEBUG_MODE) {
                    throw $e;
                }

                $this->get404();
                $output = $this->runActiveTemplate($request, $toolkit, $smarty);
            }
        } else {
            $output = $smarty->fetch($template);
        }

        $response->append($output);
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

    /**
     * получение имени шаблона
     *
     * @param iRequest $request
     * @param string $path путь до папки с шаблонами
     * @return string имя шаблона в соответствии с запрошенной секцией и экшном
     */
    public function getTemplateName($request, $path)
    {
        $module_name = $request->getModule();
        $action_name = $request->getAction();

        $tpl_name = self::TPL_PRE . $module_name . '/' . $action_name . self::TPL_EXT;
        if (file_exists($path . '/' . $tpl_name)) {
            return $tpl_name;
        }
        return false;
    }

    public function runActiveTemplate($request, $toolkit, $smarty)
    {
        $moduleName = $request->getModule();
        $actionName = $request->getAction();

        $module = $toolkit->getModule($moduleName);
        $action = $module->getAction($actionName);

        $activeTemplate = $action->getActiveTemplate();

        if ($activeTemplate == 'deny') {
            throw new mzzNoActionException('Direct access to this action is deny');
        }
        $smarty->assign('module', $moduleName);
        $smarty->assign('action', $actionName);

        return $smarty->fetch($activeTemplate);
    }
}

?>