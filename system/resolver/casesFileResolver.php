<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2005
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * casesFileResolver: �������� ����� � �������
 * �������:
 * (������ -> ���������)
 * sometest.case -> cases/sometest.case.php
 * 
 * @package system
 * @subpackage resolver
 * @version 0.1
 */

require_once SYSTEM_DIR . 'resolver/partialFileResolver.php';

class casesFileResolver extends partialFileResolver
{
    /**
     * �����������
     *
     * @access public
     * @param object $resolver ������� ��������
     */
    public function __construct($resolver)
    {
        parent::__construct($resolver);
    }
    
    /**
     * �������� �� ������������ ������� ���������� �������
     * ���������� ��� ���� ������������� ���, ������� ���������
     *
     * @access protected
     * @param string $request ������ �������
     * @return string|null ������������ ������, ���� ������ ��������� � ��������, ���� null
     */
    protected function partialResolve($request)
    {
        if (strpos($request, '.case') !== false) {
            return 'cases/' . $request . '.php';
        }
        return null;
    }
}

?>