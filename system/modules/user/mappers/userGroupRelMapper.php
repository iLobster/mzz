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
 * groupMapper: ������ ��� ����� �������������
 *
 * @package user
 * @version 0.1
 */

fileLoader::load('user/userGroupRel');

class userGroupRelMapper extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'user';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'userGroupRel';
}

?>