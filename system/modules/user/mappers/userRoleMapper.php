<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/user/mappers/userOnlineMapper.php $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userOnlineMapper.php 3857 2009-10-19 04:12:06Z zerkms $
 */

fileLoader::load('user/model/userRole');

/**
 * userRoleMapper: mapper for users roles
 *
 * @package modules
 * @subpackage user
 * @version 0.2
 */
class userRoleMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'userRole';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'user_roles';

    /**
     * Map
     *
     * @var array
     */
    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'pk',
                'once')),
        'group_id' => array(
            'accessor' => 'getGroup',
            'mutator' => 'setGroup',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'user/group',
            'options' => array(
                'once')),
        'module' => array(
            'accessor' => 'getModule',
            'mutator' => 'setModule',
            'options' => array(
                'once')),
        'role' => array(
            'accessor' => 'getRole',
            'mutator' => 'setRole',
            'options' => array(
                'once')));

    /**
     * @var user
     */
    protected $user;

    protected $roles = array();

    protected $roles_array = array();

    protected $roles_group = array();

    public function __construct($user = null)
    {
        parent::__construct();

        if (is_null($user)) {
            $user = systemToolkit::getInstance()->getUser();
        }

        $this->user = $user;
    }

    protected function getRoles($module)
    {
        if (!isset($this->roles[$module])) {
            $relMapper = systemToolkit::getInstance()->getMapper('user', 'userGroup');

            $critera = new criteria();

            $critera->where('module', $module);

            $criterion = new criterion('rel.group_id', $this->table(false) . '.group_id', criteria::EQUAL, true);
            $criterion->addAnd(new criterion('rel.user_id', $this->user->getId()));
            $critera->join($relMapper->table(), $criterion, 'rel', criteria::JOIN_INNER);

            $this->roles[$module] = $this->searchAllByCriteria($critera);
        }

        return $this->roles[$module];
    }

    protected function getRolesArray($module)
    {
        if (!isset($this->roles_array[$module])) {
            $this->roles_array[$module] = array();

            foreach ($this->getRoles($module) as $role) {
                $this->roles_array[$module][] = $role->getRole();
            }
        }

        return $this->roles_array[$module];
    }

    public function hasRole($module, $roles)
    {
        if (is_null($roles)) {
            return true;
        }

        if (!is_array($roles)) {
            $roles = array(
                $roles);
        }

        foreach ($this->getRolesArray($module) as $role) {
            if (in_array($role, $roles)) {
                return true;
            }
        }

        return false;
    }

    public function getGroups($module)
    {
        $criteria = new criteria();
        $criteria->where('module', $module);
        $criteria->groupBy('group_id');

        return $this->searchAllByCriteria($criteria);
    }

    public function getGroupsNotAddedYet($module)
    {
        $groupMapper = systemToolkit::getInstance()->getMapper('user', 'group');

        $criterion = new criterion('r.group_id', $groupMapper->table(false) . '.id', criteria::EQUAL, true);
        $criterion->addAnd(new criterion('r.module', $module));

        $criteria = new criteria($groupMapper->table());
        $criteria->join($this->table(), $criterion, 'r');
        $criteria->where('r.id', null, criteria::IS_NULL);

        return $groupMapper->searchAllByCriteria($criteria);
    }

    public function getRolesGorGroup($module, $group_id)
    {
        if (!isset($this->roles_group[$module][$group_id])) {
            $critera = new criteria();

            $critera->where('module', $module);
            $critera->where('group_id', $group_id);

            $result = array();

            foreach ($this->searchAllByCriteria($critera) as $role) {
                $result[$role->getRole()] = $role;
            }

            $this->roles_group[$module][$group_id] = $result;
        }

        return $this->roles_group[$module][$group_id];
    }

    public function deleteRolesGorGroup($module, $group_id)
    {
        $criteria = new criteria();
        $criteria->where('group_id', $group_id);
        $criteria->where('module', $module);

        foreach ($this->searchAllByCriteria($criteria) as $role) {
            $this->delete($role);
        }
    }
}

?>