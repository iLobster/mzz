<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/filters/contentFilter.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: contentFilter.php 4356 2010-11-10 03:54:10Z striker $
 */

fileLoader::load('core/loadDispatcher');


/**
 * abstractContentFilter: фильтр получения и отображения контента
 *
 * @package system
 * @subpackage filters
 * @version 0.2.9
 */
class abstractContentFilter
{
    /**
     * do changes in output after render page
     *
     * @param string $output
     */
    protected  function afterRenderPage(&$output)
    {

    }

    /**
     * render page
     *
     * @param httpResponse $response
     * @param iRequest $request
     */
    protected function renderPage($response, $request)
    {
        $params = $request->getParams();

        $toolkit = systemToolkit::getInstance();
        $view = $toolkit->getView();

        $view->assign('toolkit', $toolkit);

        $module_name = $request->getModule();
        $action_name = $request->getAction();

        $request->setRequestedParams($params);

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
        } catch (mzzModuleNotFoundException $e) {
            $errorModule = $toolkit->getModule('errorPages');
            $errorAction = $errorModule->getAction('error404');

            $output = $errorAction->run();
        } catch (mzzNoActionException $e) {
            if (!isset($action)) {
                $action = null;
            }

            $errorModule = $toolkit->getModule('errorPages');
            $errorAction = $errorModule->getAction('error404');

            $output = $errorAction->run($action);
        } catch (mzzException $e) {
            //@todo: сделать тут errorPages::error500? или отдать на съедение в errorDispatcher?
            throw $e;
        }

        // Do some changes in output
        $this->afterRenderPage($output);

        return $output;
    }
}

?>