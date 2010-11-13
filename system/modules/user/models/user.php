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
 * @version 0.1.6
 */
class user extends entity
{
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
        return !strlen($this->getConfirmed());
    }

    public function isActive()
    {
        return !is_null($this->getOnline());
    }

    public function getSkin()
    {
        $id = parent::__call('getSkin', array());
        return new skin($id);
    }

    public function isRoot()
    {
        return in_array(MZZ_ROOT_GID, $this->getGroups()->keys());
    }

    public function getHash()
    {
        return md5($this->getLogin() . $this->getPassword() . $this->getEmail());
    }
}

?>