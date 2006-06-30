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
 * user: user
 *
 * @package user
 * @version 0.1.3
 */

class user extends simple
{
    /**
     * Mapper
     *
     * @var object
     */
    private $mapper;

    /**
     *  онструктор
     *
     * @param object $mapper
     * @param array $map
     */
    public function __construct($mapper, Array $map)
    {
        $this->mapper = $mapper;
        parent::__construct($map);
    }

    /**
     * ѕровер€ет €вл€етс€ ли пользователь авторизированным
     * ѕользователь считаетс€ вторизированным, если у него
     * установлен id больше 1
     *
     * @return boolean
     */
    public function isLoggedIn()
    {
        return $this->getId() > 1;
    }

    public function getGroupsList()
    {
        return $this->mapper->getGroupsList();
    }
}

?>