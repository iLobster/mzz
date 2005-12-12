<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * RequestParser: ����� ��� ��������� ������, �������� � ������ ����������
 *
 * @package system
 * @subpackage request
 * @version 0.1
 */
class requestParser
{
    /**
     * �������� URL �� section, action, params.
     *
     */
    public function parse($path)
    {
        $path = preg_replace('/\/{2,}/', '/', $path);

        // ��������������� /path/to/document/ � path/to/document
        $path = substr($path, 1, (strlen($path) - 1) - (strrpos($path, '/') == strlen($path) - 1));

        $params = explode('/', $path);

        HttpRequest::setSection(array_shift($params));
        $action = array_pop($params);
        HttpRequest::setAction($action);

        // ���� action �����, �� ������� ��� ��� �� � � params,
        // ������� ����� ����������� ��� ��������,
        // ���� ��������� action �� ����������
        if (!empty($action)) {
            $params = array_merge($params, array($action));
        }
        HttpRequest::setParams($params);
    }

}

?>