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

        $template = $this->getTemplateName($request, $tplPath);

        $smarty->assign('current_module', $request->getRequestedModule());
        $smarty->assign('current_action', $request->getRequestedAction());
        $smarty->assign('current_path', $request->getPath());
        $smarty->assign('current_lang', $toolkit->getLocale()->getName());
        $smarty->assign('current_user', $toolkit->getUser());
        $smarty->assign('available_langs', $toolkit->getLocale()->searchAll());
        $request->setRequestedParams($request->getParams());

        if (empty($template)) {
            try {
                $output = $this->runActiveTemplate($request, $toolkit, $request, $smarty);
            } catch (mzzNoActionException $e) {
                if (DEBUG_MODE) {
                    throw $e;
                }

                $output = $this->get404();
                if ($output === false) {
                    $template = $this->getTemplateName($request, $tplPath);
                    if (empty($template)) {
                        $output = $this->runActiveTemplate($request, $toolkit, $request, $smarty);
                    }
                }
            }
        }

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

    /**
     * получение имени шаблона
     *
     * @param iRequest $request
     * @param string $path путь до папки с шаблонами
     * @return string имя шаблона в соответствии с запрошенной секцией и экшном
     */
    public function getTemplateName($request, $path)
    {
        try {
            $action = $request->getAction();
            $section = systemToolkit::getInstance()->getSectionName($request->getModule());
        } catch (mzzRuntimeException $e) {
            return false;
        }

        $tpl_name = self::TPL_PRE . $section . '/' . $action . self::TPL_EXT;
        if (file_exists($path . '/' . $tpl_name)) {
            return $tpl_name;
        }
        return false;
    }

    public function runActiveTemplate($request, $toolkit, $request, $smarty)
    {
        $module = $request->getModule();
        $action = $toolkit->getAction($module);
        $actionName = $request->getAction();
        $activeTemplate = $action->getActiveTemplate($actionName);

        if ($activeTemplate == 'deny') {
            throw new mzzNoActionException('Direct access to this action is deny');
        }
        $smarty->assign('module', $module);
        $smarty->assign('action', $actionName);

        return $smarty->fetch($activeTemplate);
    }
}

?>