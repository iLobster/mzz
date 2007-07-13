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
 * classFileResolver: �������� ������� �� ��������� � ��������
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */
class templateResolver extends partialFileResolver
{
    /**
     * �������� �� ������������ ������� ���������� �������
     * ���������� ��� ���� ������������� ���, ������� ���������
     *
     * @param string $request ������ �������
     * @return string|null ������������ ������, ���� ������ ��������� � ��������, ���� null
     */
    protected function partialResolve($request)
    {
        if (strpos($request, '/')) {
            $parts = explode('/', $request, 2);

            if (sizeof($parts) < 2) {
                return;
            }

            list($module, $template) = $parts;

            if (substr($template, -4) !== '.tpl') {
                return;
            }

            return '/modules/' . $module . '/templates/' . $template;
        }

        return;
    }
}

?>