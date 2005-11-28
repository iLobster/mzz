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
 * configFileResolver: �������� ����� ������������
 * �������:
 * (������ -> ���������)
 * configs/someconfig.ext   -> configs/someconfig.ext
 * notconfig/somefile       -> null
 * 
 * @package system
 * @subpackage resolver
 * @version 0.1
 */

require_once SYSTEM_DIR . 'resolver/partialFileResolver.php';

class configFileResolver extends partialFileResolver
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
        if (strpos($request, 'configs/') === 0) {
            return $request;
        }
        return null;
    }
}

?>