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

/**
 * baseMediaResolver: базовый резолвер для медиа-файлов
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */
abstract class baseMediaResolver extends partialFileResolver
{
    /**
     * проверка на соответствие запроса некоторому шаблону
     * определяем что файл действительно тот, который требуется
     *
     * @param string $request строка запроса
     * @return string|null переписанный запрос, если запрос совпадает с шаблоном, либо null
     */
    protected function partialResolve($request)
    {
        $fileinfo = pathinfo($request);
        if (empty($fileinfo['extension'])) {
            return false;
        }

        // pathinfo() fix for php < 5.2.0
        if (!isset($fileinfo['filename'])) {
            $fileinfo['filename'] = substr($fileinfo['basename'], 0, -(1 + strlen($fileinfo['extension'])));
        }

        $images_extensions = array('jpg', 'png', 'gif');
        $valid_extensions = array('css', 'js', 'html', 'htm');
        $valid_extensions = array_merge($valid_extensions, $images_extensions);

        if (in_array($fileinfo['extension'], $valid_extensions)) {
            if (in_array($fileinfo['extension'], $images_extensions)) {
                $fileinfo['extension'] = 'images';
            }

            $slash_count = substr_count($request, '/');

            return $this->process($fileinfo, $slash_count, $request);
        }

        return;
    }

    /**
     * Метод для непосредственно вычисления пути
     *
     * @param array $fileinfo
     * @param integer $slash_count
     * @param string $request
     */
    abstract protected function process(Array $fileinfo, $slash_count, $request);
}

?>