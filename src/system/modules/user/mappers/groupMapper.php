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

fileLoader::load('user/models/group');
fileLoader::load('modules/jip/plugins/jipPlugin');

/**
 * groupMapper: mapper for user groups
 *
 * @package modules
 * @subpackage user
 * @version 0.2
 */
class groupMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'group';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'user_group';

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
        'name' => array(
            'accessor' => 'getName',
            'mutator' => 'setName'),
        'users' => array(
            'accessor' => 'getUsers',
            'mutator' => 'setUsers',
            'relation' => 'many-to-many',
            'mapper' => 'user/user',
            'reference' => 'user_userGroup_rel',
            'local_key' => 'id',
            'foreign_key' => 'id',
            'ref_local_key' => 'group_id',
            'ref_foreign_key' => 'user_id'),
        'is_default' => array(
            'accessor' => 'getIsDefault',
            'mutator' => 'setIsDefault'));

    public function __construct($module)
    {
        parent::__construct($module);
        $this->plugins('jip');
        $this->plugins('identityMap');
    }

    public function searchDefaultGroups()
    {
        return $this->searchAllByField('is_default', 1);
    }
}

?>