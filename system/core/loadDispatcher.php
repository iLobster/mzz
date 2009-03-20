<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage template
 * @version $Id$
*/

fileLoader::load('acl');

/**
 * loadDispatcher: dispatches load params to a controller of a module
 *
 * @package system
 * @subpackage core
 * @version 0.1
 */
class loadDispatcher
{
    /**
     * Request
     *
     * @var iRequest
     */
    static protected $request;

    /**
     * Dispatch load params to a controller
     *
     * @param string $section
     * @param string $module
     * @param string $actionName
     * @param array $params
     * @return string|null
     */
    static public function dispatch($section, $module, $actionName, $params)
    {
        if (empty($module)) {
            throw new mzzRuntimeException("Module loading error: the name of the module is not specified.");
        }

        $toolkit = systemToolkit::getInstance();

        // prepare action
        $action = $toolkit->getAction($module);
        $action->setAction($actionName);
        $actionConfig = $action->getAction();
        $handle403 = isset($actionConfig['403handle']) ? $actionConfig['403handle'] : false;

        // prepare request
        $request = $toolkit->getRequest();
        $request->save();
        $request->setAction($action->getActionName());
        if (!empty($section)) {
            $request->setSection($section);
        }
        foreach ($params as $name => $value) {
            $request->setParam($name, $value);
        }
        $request->setRequestedParams($request->getParams());
        if (empty(self::$request)) {
            self::$request = $request;
        }

        // доступ разрешен перед проверкой прав
        $access = true;

        // проверяем - не отключена ли в данном запуске модуля проверка прав
        if ($handle403 !== 'none') {
            $mappername = $action->getClass() . 'Mapper';
            $mapper = $toolkit->getMapper($module, $action->getClass(), $request->getSection());

            try {
                $access = self::getAccess($mapper, $action);
            } catch (mzzDONotFoundException $e) {
                fileLoader::load('simple/simple404Controller');
                $controller = new simple404Controller();
                $controller->applyMapper($mapper);
            }
        }

        // проверяем, не включен ли ручной режим проверки прав
        if ($handle403 === 'manual') {
            $request->setParam('access', $access);
            $access = true;
        }

        // run action if we have access
        if ($access) {
            if (empty($controller)) {
                // если права на запуск модуля есть - запускаем
                $factory = new simpleFactory($action, $module);
                $controller = $factory->getController();
            }
        } else {
            // если прав нет - запускаем либо стандартное сообщение о 403 ошибке, либо пользовательское
            if (!isset($params['403tpl'])) {
                fileLoader::load('simple/simple403Controller');
                $controller = new simple403Controller();
            } else {
                $smarty = $toolkit->getSmarty();
                $view = $smarty->fetch($params['403tpl']);
                $request->restore();

                if (!empty($params['403header'])) {
                    $toolkit->getResponse()->setStatus(403);
                }
            }
        }

        if (isset($controller)) {
            // если есть контроллер для запуска - запускаем и получаем контент
            $view = $controller->run();
            $request->restore();
        }

        // отдаём контент
        return $view;
    }

    /**
     * Get access to an action using the mapper and the action class
     *
     * @param string $mapper
     * @param string $action
     * @return boolean
     */
    protected static function getAccess($mapper, $action)
    {
        $args = self::$request->getParams();

        $actionName = $action->getActionName(true);

        if (isset($args['section_name']) && isset($args['module_name']) && $actionName == 'admin') {
            $toolkit = systemToolkit::getInstance();
            $mapper = $toolkit->getMapper('admin', 'admin', self::$request->getSection());
        }

        $obj = $mapper->convertArgsToObj($args);

        return $obj->getAcl($actionName);
    }
}

?>