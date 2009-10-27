<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/resolver/moduleMediaResolver.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: moduleMediaResolver.php 2758 2008-11-17 03:50:44Z zerkms $
 */

require_once systemConfig::$pathToSystem . '/resolver/partialFileResolver.php';
require_once systemConfig::$pathToSystem . '/resolver/baseMediaResolver.php';

/**
 * templateMediaResolver: резолвит медиафайлы (css, js, images) модулей из директории с шаблонами
 *
 * @package system
 * @subpackage resolver
 * @version 0.1.4
 */
class templateMediaResolver extends baseMediaResolver
{
    protected function process(Array $fileinfo, $slash_count, $request)
    {
        return $fileinfo['extension'] . '/' . $request;
    }
}

?>