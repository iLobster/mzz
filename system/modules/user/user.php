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

    /**
     * ��������� �������� �� ������������ ����������������
     * ������������ ��������� �������, ���� � ���� ����������
     * id ������ 0 � �� �� ����� �������� ��������� MZZ_USER_GUEST_ID
     *
     * @return boolean
     */
    public function isLoggedIn()
    {
        return $this->getId() > 0 && $this->getId() !=  MZZ_USER_GUEST_ID;
    }

    /**
     * ��������� ������ �����, � ������� ������� ������������
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

    public function __sleep()
    {
        $this->section($this->mapper->section());
        return array('fields', 'map', 'section');
    }

    public function __wakeup()
    {
        $this->mapper = systemToolkit::getInstance()->getmapper('user', 'user', $this->section());
    }
}

?>