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
 * userFilter: фильтр для инициализации текущего пользователя
 *
 * @package system
 * @subpackage filters
 * @version 0.1.2
 */
class userFilter implements iFilter
{
    /**
     * запуск фильтра на исполнение
     *
     * @param filterChain $filter_chain объект, содержащий цепочку фильтров
     * @param httpResponse $response объект, содержащий информацию, выводимую клиенту в браузер
     * @param iRequest $request
     */
    public function run(filterChain $filter_chain, $response, iRequest $request)
    {
        $toolkit = systemToolkit::getInstance();

        $userMapper = $toolkit->getMapper('user', 'user', 'user');
        $user_id = $userMapper->getUserId();

        if (is_null($user_id)) {
            $userAuthMapper = $toolkit->getMapper('user', 'userAuth', 'user');
            $userAuth = $userAuthMapper->get();
            // если пользователь сохранил авторизацию, тогда восстанавливаем её
            if (!is_null($userAuth)) {
                $user_id = $userAuth->getUserId();
                $userMapper->setUserId($user_id);
            }

            // если авторизация пользователя не найдена - то устанавливаем user_id гостя
            if (is_null($user_id)) {
                $user_id = MZZ_USER_GUEST_ID;
            }
        }

        $me = $userMapper->searchById($user_id);

        $toolkit->setUser($me);

        $filter_chain->next();
    }
}

?>