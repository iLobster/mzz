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
 * ResolvingFilter: ������ ��� ����������� ����������� ������� ������
 *
 * @package system
 * @version 0.1
 */

class ResolvingFilter
{
    /**
     * ������ ������� �� ����������
     *
     * @param filterChain $filter_chain ������, ���������� ������� ��������
     * @param response $response ������, ���������� ����������, ��������� ������� � �������
     */
    public function run($filter_chain, $response)
    {
        $this->resolve();
        $filter_chain->next();
    }

    /**
     * ����������� ����������� ������
     *
     * @access private
     */
    private function resolve()
    {
        FileLoader::load('config/Config');
        FileLoader::load('request/Rewrite');
        FileLoader::load('request/HttpRequest');
        FileLoader::load('request/RequestParser');
        FileLoader::load('FrontController');
        FileLoader::load('core/Fs');
        FileLoader::load('core/SectionMapper');
        FileLoader::load('db/DbFactory');
        FileLoader::load('simple/simple.view');
    }
}

?>