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

    /**
     * �����������
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

    public function getGroupsList()
    {
        return $this->mapper->getGroupsList($this->getId());
    }

}

?>