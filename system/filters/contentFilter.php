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
 * @version 0.2.9
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
        $params = $request->getParams();

        $toolkit = systemToolkit::getInstance();
        $view = $toolkit->getView();

        $view->assign('toolkit', $toolkit);

        $request->setRequestedParams($params);

        $module_name = $request->getModule();
        $action_name = $request->getAction();

        //нам еще нужны эти активные шаблоны?
        $tpl_path = systemConfig::$pathToApplication . '/templates';
        $tpl_name = 'act' . DIRECTORY_SEPARATOR . $module_name . DIRECTORY_SEPARATOR . $action_name . '.tpl';
        if (file_exists($tpl_path . DIRECTORY_SEPARATOR . $tpl_name)) {
            return $view->render('templates' . DIRECTORY_SEPARATOR . $tpl_name, systemConfig::$mainTemplateDriver);
        }

        try {
            $module = $toolkit->getModule($module_name);
            $action = $module->getAction($action_name);

            $active_template = $action->getActiveTemplate();

            if ($active_template == 'deny') {
                throw new mzzNoActionException('Direct access to this action is deny');
            }

            $output = loadDispatcher::dispatch($module_name, $action_name, $params);

            if ($view->withMain()) {
                //@todo: перенесли это сюда из simpleController:208
                if ($action->isJip() && $request->isJip()) {
                    $active_template = 'main.xml.tpl';
                }

                switch ($active_template) {
                    case 'active.main.tpl':
                        $view->assign('content', $output);
                        $output = $view->render('templates/main.tpl', systemConfig::$mainTemplateDriver);
                        break;

                    case 'active.headeronly.tpl':
                        $view->assign('content', $output);
                        $output = $view->render('templates/header.tpl', systemConfig::$mainTemplateDriver);
                        break;

                    case 'active.blank.tpl':
                        break;

                    //@todo: выбрать шаблонизатор для админки
                    case 'active.admin.tpl':
                        $view->assign('content', $output);
                        $output = $view->render('admin/main/admin.tpl', 'smarty');
                        break;

                    default:
                        $driver_active_template = 'template/drivers/' . systemConfig::$mainTemplateDriver . '/templates/' . $active_template;
                        $view->assign('content', $output);
                        $output = $view->render($driver_active_template, systemConfig::$mainTemplateDriver);
                        break;
                }
            }

            //$output = $this->runActiveTemplate($request, $toolkit, $view);
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

    /*
    public function runActiveTemplate($request, $toolkit, $view)
    {
        $module_name = $request->getModule();
        $action_name = $request->getAction();

        $tpl_path = systemConfig::$pathToApplication . '/templates';
        $tpl_name = 'act' . DIRECTORY_SEPARATOR . $module_name . DIRECTORY_SEPARATOR . $action_name . '.tpl';
        if (file_exists($tpl_path . DIRECTORY_SEPARATOR . $tpl_name)) {
            return $view->render('templates' . DIRECTORY_SEPARATOR . $tpl_name, systemConfig::$mainTemplateDriver);
        }

        $module = $toolkit->getModule($module_name);
        $action = $module->getAction($action_name);

        $active_template = $action->getActiveTemplate();

        if ($active_template == 'deny') {
            throw new mzzNoActionException('Direct access to this action is deny');
        }

        $driver_active_template = 'template/drivers/' . systemConfig::$mainTemplateDriver . '/templates/' . $active_template;

        $view->assign('module', $module_name);
        $view->assign('action', $action_name);

        return $view->render($driver_active_template, systemConfig::$mainTemplateDriver);
    }
    */
}

?>