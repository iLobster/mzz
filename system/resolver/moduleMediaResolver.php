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

require_once systemConfig::$pathToSystem . '/resolver/partialFileResolver.php';

/**
 * moduleMediaResolver: резолвит медиафайлы (css, js, images) модулей
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */
class moduleMediaResolver extends partialFileResolver
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

        $images_extensions = array('jpg', 'png', 'gif');
        $valid_extensions = array('css', 'js');
        $valid_extensions = array_merge($valid_extensions, $images_extensions);

        if (in_array($fileinfo['extension'], $valid_extensions)) {
            if (in_array($fileinfo['extension'], $images_extensions)) {
                $fileinfo['extension'] = 'img';
            }

            $slash_count = substr_count($request, '/');

            if (!$slash_count) {
                return '/modules/' . $fileinfo['filename'] . '/templates/' . $fileinfo['extension'] . '/' . $fileinfo['basename'];
            } elseif ($slash_count == 1) {
                list($module, $file) = explode('/', $request);
                return '/modules/' . $module . '/templates/' . $fileinfo['extension'] . '/' . $fileinfo['basename'];
            }

            throw new mzzRuntimeException('Невозможно обработать ' . htmlspecialchars($request));
        }

        return;
    }
}

?>