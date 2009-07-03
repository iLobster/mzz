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

        $userMapper = $toolkit->getMapper('user', 'user');
        $user_id = $toolkit->getSession()->get('user_id');

        if (is_null($user_id)) {
            $userAuth = $toolkit->getUserAuth();
            // если пользователь сохранил авторизацию, тогда восстанавливаем её
            if (!is_null($userAuth)) {
                $user_id = $userAuth->getUserId();
            }
        }

        $toolkit->setUser($user_id);

        $filter_chain->next();
    }
}

?>