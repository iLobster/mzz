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
 * libResolver: �������� ����� ��������� ���������
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */

require_once systemConfig::$pathToSystem  . '/resolver/partialFileResolver.php';

class libResolver extends partialFileResolver
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
        if (strpos($request, 'libs/') === 0) {
            return $request . '.php';
        } else {
            return null;
        }
    }
}

?>