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

fileLoader::load('service/skin');

/**
 * user: user
 *
 * @package modules
 * @subpackage user
 * @version 0.1.5
 */
class user extends simple
{
    protected $name = 'user';

    protected $online = false;

    /**
     * Проверяет является ли пользователь авторизированным
     * Пользователь считается таковым, если у него установлен
     * id больше 0 и он не равен значению константы MZZ_USER_GUEST_ID
     *
     * @return boolean
     */
    public function isLoggedIn()
    {
        return $this->getId() > 0 && $this->getId() !=  MZZ_USER_GUEST_ID;
    }

    public function isConfirmed()
    {
        return is_null($this->getConfirmed());
    }

    public function getOnline()
    {
        if ($this->online === false) {
            $this->online = $this->mapper->getOnline($this->getId());
        }

        return $this->online;
    }

    public function isActive()
    {
        return !is_null($this->getOnline());
    }

    /**
     * Получение списка групп, в которых состоит пользователь
     *
     * @return array
     */
    public function getGroupsList()
    {
        $toolkit = systemToolkit::getInstance();
        $cache = $toolkit->getCache();

        if (is_null($groups = $cache->get($identifier = 'groups_' . $this->getId()))) {
            $groups = $this->mapper->getGroupsList($this->getId());
            $cache->set($identifier, $groups);
        }

        return $groups;
    }

    public function __sleep()
    {
        $this->section($this->mapper->section());
        return array('fields', 'map', 'section');
    }

    public function __wakeup()
    {
        $this->mapper = systemToolkit::getInstance()->getmapper('user', 'user', $this->section());
    }

    public function getSkin()
    {
        $id = parent::__call('getSkin', array());
        return new skin($id);
    }

    public function getTimezone()
    {
        $tz = parent::__call('getTimezone', array());
        if (strtotime('last sunday april 2008') < strtotime('today') && strtotime('last sunday november 2008') > strtotime('today')) {
            $tz++;
        }

        return $tz;
    }
}

?>