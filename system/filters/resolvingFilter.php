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
 * resolvingFilter: ������ ��� ����������� ����������� ������� ������
 *
 * @package system
 * @version 0.1
 */

class resolvingFilter
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
        fileLoader::load('config/config');
        fileLoader::load('request/rewrite');
        fileLoader::load('request/httpRequest');
        fileLoader::load('request/requestParser');
        fileLoader::load('frontController');
        fileLoader::load('core/Fs');
        fileLoader::load('core/sectionMapper');
        fileLoader::load('db/dbFactory');
        fileLoader::load('simple/simple.view');
    }
}

?>