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

fileLoader::load('user/model/userGroup');

/**
 * userGroupMapper
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */
class userGroupMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'userGroup';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'user_userGroup_rel';

    /**
     * Map
     *
     * @var array
     */
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
            'mapper' => 'user/user'),
        'group_id' => array(
            'accessor' => 'getGroup',
            'mutator' => 'setGroup',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'user/group'));
}

?>