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
 * LibResolver: �������� ����� ��������� ���������
 * 
 * @package system
 * @subpackage resolver
 * @version 0.1
 */

require_once SystemConfig::$pathToSystem  . 'resolver/PartialFileResolver.php';

class LibResolver extends PartialFileResolver
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
    	if (strpos($request, 'libs/') === 0) {
        	return $request . '.php';
        } else {
        	return null;
        }
    }
}

?>