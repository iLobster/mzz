<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage filters
 * @version $Id$
*/

/**
 * userOnlineFilter: ������ ��� ������������ ������������� ������
 *
 * @package system
 * @subpackage filters
 * @version 0.1
 */
class userOnlineFilter implements iFilter
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
        // ��������� ���� � ������ ������-�������������
        $userOnlineMapper = $toolkit->getMapper('user', 'userOnline', 'user');
        $userOnlineMapper->refresh($toolkit->getUser());

        $filter_chain->next();
    }
}

?>