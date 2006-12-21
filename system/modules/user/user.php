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
 * @package modules
 * @subpackage user
 * @version 0.1.4
 */

class user extends simple
{
    /**
     * Mapper
     *
     * @var object
     */
    private $mapper;

    protected $name = 'user';

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
     * ѕользователь считаетс€ таковым, если у него установлен
     * id больше 0 и он не равен значению константы MZZ_USER_GUEST_ID
     *
     * @return boolean
     */
    public function isLoggedIn()
    {
        return $this->getId() > 0 && $this->getId() !=  MZZ_USER_GUEST_ID;
    }

    /**
     * ѕолучение списка групп, в которых состоит пользователь
     *
     * @return array
     */
    public function getGroupsList()
    {
        $toolkit = systemToolkit::getInstance();
        $cache = $toolkit->getCache();

        if (is_null($groups = $cache->load($identifier = 'groups_' . $this->getId()))) {
            $groups = $this->mapper->getGroupsList($this->getId());
            $cache->save($identifier, $groups);
        }
        
        return $groups;
    }
}

?>