<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/resolver/configFileResolver.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: configFileResolver.php 3719 2009-09-21 04:48:34Z zerkms $
 */

/**
 * commonFileResolver
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */
class commonFileResolver extends partialFileResolver
{
    protected function partialResolve($request)
    {
        if (substr($request, 0, 8) === 'configs/') {
            return $request;
        }

        if (substr($request, -4) === '.tpl') {
            if (strpos($request, '/') === false) {
                $request = 'simple/' . $request;
            }

            list ($module, $template) = explode('/', $request, 2);

            if (strpos($request, 'templates/') === false) {
                return '/modules/' . $module . '/templates/' . $template;
            } else {
                return $request;
            }
        }

        if (substr($request, 0, 5) === 'libs/') {
            return '../' . $request . '.php';
        }
    }
}

?>