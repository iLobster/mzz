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
 * @package modules
 * @subpackage user
 * @version 0.1
 */

fileLoader::load('user/userGroup');

class userGroupMapper extends simpleMapper
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
    protected $className = 'userGroup';

    /**
     * �����������
     *
     * @param string $section ������
     * @param string $alias �������� ���������� � ��
     */
    public function __construct($section, $alias = 'default')
    {
        parent::__construct($section, $alias);
        $this->table = $this->table . '_rel';
    }

    /**
     * @todo �������
     *
     * @param unknown_type $args
     */
    public function convertArgsToId($args)
    {

    }
}

?>