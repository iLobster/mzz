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

require_once systemConfig::$pathToSystem  . 'resolver/partialFileResolver.php';

class libResolver extends partialFileResolver
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
     * ????? ���� �������� ������� �������
     * 1. ���� ������: fileLoader::load('Smarty/Smarty.class');, ����� ������������� ���� �������� �� fileResolver (���� appFileResolver/sysFileResolver)
     * 2. ���� ������� ��� ����������� ����������������� � ����������� fileLoader::load('libs/Smarty/Smarty.class');
     *
     * @access protected
     * @param string $request ������ �������
     * @return string|null ������������ ������, ���� ������ ��������� � ��������, ���� null
     */
    protected function partialResolve($request)
    {
        return 'libs/' . $request . '.php';
    }
}

?>