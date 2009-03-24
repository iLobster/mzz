<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * accessMapper: маппер
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */

fileLoader::load('access');

class accessMapper extends mapper
{
    protected $table = 'sys_access';
    protected $class = 'access';

    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'once',
                'pk')),
        'uid' => array(
            'accessor' => 'getUser',
            'mutator' => 'setUser',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'userMapper'),
        'gid' => array(
            'accessor' => 'getGroup',
            'mutator' => 'setGroup',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'groupMapper'),
        'allow' => array(
            'accessor' => 'getAllow',
            'mutator' => 'setAllow'),
        'deny' => array(
            'accessor' => 'getDeny',
            'mutator' => 'setDeny'),
        'action_id' => array(
            'accessor' => 'getAction_id',
            'mutator' => 'setAction_id'),
        'section_id' => array(
            'accessor' => 'getSection_id',
            'mutator' => 'setSection_id'));

    public function __construct()
    {
        parent::__construct();
        $this->plugins('acl_ext');
    }

    public function searchByObjId($obj_id)
    {
        return $this->searchAllByField('obj_id', $obj_id);
    }

    public function convertArgsToObj($args)
    {
        $access = $this->create();

        if (isset($args['section_name']) && isset($args['class_name'])) {
            throw new mzzRuntimeException('refactor me!');
            $toolkit = systemToolkit::getInstance();
            $obj_id = $toolkit->getObjectId('access_' . $args['section_name'] . '_' . $args['class_name']);
            $this->register($obj_id, 'sys', 'access');

            $access->merge(array(
                'obj_id' => $obj_id));
            return $access;
        }

        if (isset($args['id'])) {
            $access->merge(array(
                'obj_id' => $args['id']));
            return $access;
        }

        throw new mzzDONotFoundException();
    }
}

?>