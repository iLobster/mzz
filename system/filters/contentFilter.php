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

        $module_name = $request->getModule();
        $action_name = $request->getAction();

        $request->setRequestedParams($params);

        //нам еще нужны эти активные шаблоны?
        $tpl_path = systemConfig::$pathToApplication . '/templates';
        $tpl_name = 'act' . DIRECTORY_SEPARATOR . $module_name . DIRECTORY_SEPARATOR . $action_name . '.tpl';
        if (file_exists($tpl_path . DIRECTORY_SEPARATOR . $tpl_name)) {
            $output = $view->render($tpl_name, systemConfig::$defaultTemplateDriver);
            $response->append($output);

            $filter_chain->next();
            return;
        }

        try {
            $module = $toolkit->getModule($module_name);
            $action = $module->getAction($action_name);

            $active_template = $action->getActiveTemplate();

            if ($active_template == 'deny') {
                throw new mzzNoActionException('Direct access to this action is deny');
            }

            $output = loadDispatcher::dispatch($module_name, $action_name, $params);

            // if the action has forwarded to another action, we should get a new active template.
            if ($forwarded = $request->getForwardedTo()) {
                $module = $toolkit->getModule($forwarded['module']);
                $active_template = $module->getAction($forwarded['action'])->getActiveTemplate();
            }

            if ($view->withMain()) {
                //@todo: перенесли это сюда из simpleController:208
                if ($action->isJip() && $request->isJip()) {
                    $active_template = 'main.xml.tpl';
                }

                switch ($active_template) {
                    case 'active.main.tpl':
                        $view->assign('content', $output);
                        $output = $view->render('templates/main.tpl', systemConfig::$internalTemplateDriver);
                        break;

                    case 'active.headeronly.tpl':
                        $view->assign('content', $output);
                        $output = $view->render('templates/header.tpl', systemConfig::$internalTemplateDriver);
                        break;

                    case 'active.blank.tpl':
                        break;

                    //@todo: выбрать шаблонизатор для админки
                    case 'active.admin.tpl':
                        $view->assign('content', $output);
                        $output = $view->render('admin/main/admin.tpl', systemConfig::$internalTemplateDriver);
                        break;

                    default:
                        if ( ($pos = strpos($active_template, '://')) !== false) {
                            $active_template_file = substr($active_template, $pos + 3);
                            $active_template_driver = substr($active_template, 0, $pos);
                        } else {
                            $active_template_file = $active_template;
                            $active_template_driver = systemConfig::$defaultTemplateDriver;
                        }

                        $view->assign('content', $output);
                        $output = $view->render($active_template_file, $active_template_driver);
                        break;
                }
            }

            //$output = $this->runActiveTemplate($request, $toolkit, $view);
        } catch (mzzException $e) {
            //@moved to external handler for simple rewriting
            fileLoader::load('simple/contentFilterExceptionHandler');
            $handler = new contentFilterExceptionHandler();
            $output = $handler->handle($e);
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
            return $view->render('templates' . DIRECTORY_SEPARATOR . $tpl_name, systemConfig::$defaultTemplateDriver);
        }

        $module = $toolkit->getModule($module_name);
        $action = $module->getAction($action_name);

        $active_template = $action->getActiveTemplate();

        if ($active_template == 'deny') {
            throw new mzzNoActionException('Direct access to this action is deny');
        }

        $driver_active_template = 'template/drivers/' . systemConfig::$defaultTemplateDriver . '/templates/' . $active_template;

        $view->assign('module', $module_name);
        $view->assign('action', $action_name);

        return $view->render($driver_active_template, systemConfig::$defaultTemplateDriver);
    }
    */
}

?>