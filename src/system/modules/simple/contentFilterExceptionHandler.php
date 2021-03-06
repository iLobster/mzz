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
 * Handles exceptions in contentFilter
 */
class contentFilterExceptionHandler
{

    /**
     * Handles exception
     *
     * @param Exception $exception
     * @return mixed
     */
    public function handle(Exception $exception)
    {
        if (DEBUG_MODE) {
            throw $exception;
        }

        $errorModule = systemToolkit::getInstance()->getModule('errorPages');
        $errorAction = $errorModule->getAction('error404');
        return $errorAction->run();
    }

}
?>