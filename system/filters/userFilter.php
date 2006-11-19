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

fileLoader::load("user/mappers/userMapper");

/**
 * userFilter: фильтр для инициализации текущего пользователя
 *
 * @package system
 * @subpackage filters
 * @version 0.1
 */
class userFilter implements iFilter
{
    /**
     * запуск фильтра на исполнение
     *
     * @param filterChain $filter_chain объект, содержащий цепочку фильтров
     * @param httpResponse $response объект, содержащий информацию, выводимую клиенту в браузер
     * @param iRequest $request
     * @param string $alias алиас соединения с БД
     */
    public function run(filterChain $filter_chain, $response, iRequest $request, $alias = 'default')
    {
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();
        $session = $toolkit->getSession();

        $user_id = $session->get('user_id');

        if (is_null($user_id)) {
            $userAuthMapper = $toolkit->getMapper('user', 'userAuth', 'user');
            $userAuth = $userAuthMapper->get();
            if (!is_null($userAuth)) {
                $user_id = $userAuth->getUserId();
                $session->set('user_id', $user_id);
            }
        }

        if (is_null($user_id)) {
            $user_id = MZZ_USER_GUEST_ID;
        }

        // @todo хм... начинаем зависеть от таблы??
        //$userMapper = $toolkit->getCache(new userMapper('user'));
        $userMapper = $toolkit->getMapper('user', 'user', 'user', $alias);

        $me = $userMapper->searchById($user_id);

        $toolkit->setUser($me);

        $filter_chain->next();
    }
}

?>