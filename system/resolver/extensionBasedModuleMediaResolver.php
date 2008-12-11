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
 * @version $Id: moduleMediaResolver.php 2859 2008-12-10 23:51:32Z zerkms $
 */

require_once systemConfig::$pathToSystem . '/resolver/partialFileResolver.php';
require_once systemConfig::$pathToSystem . '/resolver/baseMediaResolver.php';

/**
 * extensionBasedModuleMediaResolver: резолвит медиафайлы (css, js, images) модулей, в построении учитывается тип медиа-файла
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */
class extensionBasedModuleMediaResolver extends baseMediaResolver
{
    protected function process(Array $fileinfo, $slash_count, $request)
    {
        if (!$slash_count) {
            return 'modules/' . $fileinfo['filename'] . '/templates/' . $fileinfo['extension'] . '/' . $fileinfo['basename'];
        }

        list ($module, $file) = explode('/', $request, 2);
        return 'modules/' . $module . '/templates/' . $fileinfo['extension'] . '/' . $file;
    }
}

?>