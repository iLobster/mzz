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
 * classFileResolver: резолвит шаблоны из каталогов с модулями
 *
 * @package system
 * @subpackage resolver
 * @version 0.1.1
 */
class templateResolver extends partialFileResolver
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
        if (substr($request, -4) != '.tpl') {
            return;
        }

        if (strpos($request, '/') === false) {
            $request = 'simple/' . $request;
        }

        list ($module, $template) = explode('/', $request, 2);

        return '/modules/' . $module . '/templates/' . $template;
    }
}

?>