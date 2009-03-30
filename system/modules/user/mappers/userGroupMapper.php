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

fileLoader::load('user/userGroup');

/**
 * userGroupMapper:
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */
class userGroupMapper extends mapper
{
    protected $table = 'user_userGroup_rel';
    protected $class = 'userGroup';

    public $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'pk')),
         'user_id' => array(
            'accessor' => 'getUser',
            'mutator' => 'setUser',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'userMapper'),
        'group_id' => array(
            'accessor' => 'getGroup',
            'mutator' => 'setGroup',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'groupMapper'));
}

?>