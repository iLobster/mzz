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
 * userFilter: ������ ��� ������������� �������� ������������
 *
 * @package system
 * @subpackage filters
 * @version 0.1.2
 */
class userFilter implements iFilter
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
        $session = $toolkit->getSession();

        $userMapper = $toolkit->getMapper('user', 'user', 'user');

        $user_id = $userMapper->getUserId();
        $me = $session->get('user');

        if ($user_id != $me->getId()) {
            $me = null;
        }

        if (is_null($me)) {
            $userAuthMapper = $toolkit->getMapper('user', 'userAuth', 'user');
            $userAuth = $userAuthMapper->get();
            if (!is_null($userAuth)) {
                $user_id = $userAuth->getUserId();
                $userMapper->setUserId($user_id);
            }

            if (is_null($user_id)) {
                $user_id = MZZ_USER_GUEST_ID;
            }

            $me = $userMapper->searchById($user_id);

            $session->set('user', $me);
        }

        $toolkit->setUser($me);

        $filter_chain->next();
    }
}

?>