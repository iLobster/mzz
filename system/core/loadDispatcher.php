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
    protected static $request;

    /**
     * Dispatch load params to a controller
     *
     * @param string $module
     * @param string $actionName
     * @param array $params
     * @return string|null
     */
    static public function dispatch($moduleName, $actionName, $params = array())
    {
        if (empty($moduleName)) {
            throw new mzzRuntimeException("Module loading error: the name of the module is not specified.");
        }

        $toolkit = systemToolkit::getInstance();

        $module = $toolkit->getModule($moduleName);
        $action = $module->getAction($actionName);

        // prepare request
        $request = $toolkit->getRequest();
        $request->save();
        $request->setModule($moduleName);
        $request->setAction($actionName);

        foreach ($params as $name => $value) {
            $request->setParam($name, $value);
        }
        if (empty(self::$request)) {
            self::$request = $request;
        }

        $mapper = $module->getMapper($action->getClassName());
        if ($mapper instanceof iACLMapper) {
            $object = $mapper->convertArgsToObj(self::$request->getParams());
            $action->setObject($object);
        }

        // run action if we have access
        if ($action->canRun()) {
            $view = $action->run();
        } else {
            fileLoader::load('simple/simple403Controller');
            $controller = new simple403Controller($action);
            $view = $controller->run();
        }

        $request->restore();

        // отдаём контент
        return $view;
    }
}

?>