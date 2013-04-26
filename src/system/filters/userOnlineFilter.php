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
 * userOnlineFilter: фильтр для фиксирования пользователей онлайн
 *
 * @package system
 * @subpackage filters
 * @version 0.1
 */
class userOnlineFilter implements iFilter
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
        // обновляем себя в списке онлайн-пользователей
        $userOnlineMapper = $toolkit->getMapper('user', 'userOnline', 'user');
        $userOnlineMapper->refresh($toolkit->getUser());

        $filter_chain->next();
    }
}

?>