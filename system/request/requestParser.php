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
 * @version 0.2.2
 */
class requestParser
{

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * �������� URL �� section, action, params.
     *
     * @param object $request
     */
    public function parse($request, $path)
    {
        if (!is_scalar($path)) {
            $path = (string)$path;
        }

        $params = $this->extractParams($path);

        $section = array_shift($params);
        $request->setSection($section);

        $action = array_pop($params);
        $request->setAction($action);

        $request->setParams($params);
    }

    /**
     * ������� ������ ������� �� ������ "/" � ����������
     * ����������� �� ������ ������
     *
     * @param string $path
     * @return array
     */
    protected function extractParams($path)
    {
        // ������� �� ���������� ������ � �������
        $path = preg_replace('/\/{2,}/', '/', $path);

        // ������� �� ������ � ������ � � ����� �������
        $path = preg_replace('/^\/|\/$/', '', $path);

        return explode('/', $path);
    }
}

?>