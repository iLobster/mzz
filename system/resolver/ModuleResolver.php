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
 * ModuleResolver: �������� ����� �������
 * 
 * @package system
 * @subpackage resolver
 * @version 0.1
 */

require_once SystemConfig::$pathToSystem . 'resolver/PartialFileResolver.php';

class ModuleResolver extends PartialFileResolver
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
        $result = null;

        // �������� ��� news.factory ������������ � news/news.factory
        if (preg_match('/^([a-z]+)\.factory$/i', $request, $matches) == true) {
            $request = $matches[1] . '/' . $request;
            // �������� ��� news.list.controller ������������ � news/news.list.controller
        } elseif (preg_match('/^([a-z]+)(?:\.[a-z]+){2,}$/i', $request, $matches) == true) {
            $request = $matches[1] . '/' . $request;
        }

        if (preg_match('/^[a-z]+\/[a-z\.]+$/i', $request) == true) {
            $result = 'modules/' . $request . '.php';
        }
        return $result;
    }
}

?>