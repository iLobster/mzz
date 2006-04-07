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
 * classFileResolver: �������� �������� ������
 * �������:
 * (������ -> ���������)
 * core         -> core/core.php
 * module/bla   -> module/bla.php
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */

require_once systemConfig::$pathToSystem . '/resolver/partialFileResolver.php';

class classFileResolver extends partialFileResolver
{
    /**
     * �����������
     *
     * @param object $resolver ������� ��������
     */
    public function __construct(iResolver $resolver)
    {
        parent::__construct($resolver);
    }

    /**
     * �������� �� ������������ ������� ���������� �������
     * ���������� ��� ���� ������������� ���, ������� ���������
     *
     * @param string $request ������ �������
     * @return string|null ������������ ������, ���� ������ ��������� � ��������, ���� null
     */
    protected function partialResolve($request)
    {
        $result = $request;
        if (strpos($request, '/') === false) {
            $result = $request . '/' . $request;
        }
        return $result . '.php';
    }
}

?>