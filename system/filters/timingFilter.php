<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * timingFilter: ������ ��� �������� ������� ���������� �������
 *
 * @package system
 * @subpackage filters
 * @version 0.2
 */

fileLoader::load('timer/timer');

class timingFilter implements iFilter
{
    /**
     * ������ ������� �� ����������
     *
     * @param filterChain $filter_chain ������, ���������� ������� ��������
     * @param httpResponse $response ������, ���������� ����������, ��������� ������� � �������
     * @param iRequest $request
     */
    public function run(filterChain $filter_chain, $response, iRequest $request)
    {
        $toolkit = systemToolkit::getInstance();
        $toolkit->getTimer();

        $filter_chain->next();
    }
}

?>