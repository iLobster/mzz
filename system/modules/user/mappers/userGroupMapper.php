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
 * groupMapper: маппер для групп пользователей
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

fileLoader::load('user/userGroup');

class userGroupMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'user';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'userGroup';

    public function deleteByGroupId($group_id, $user_id)
    {
        if (is_array($group_id)) {
            foreach ($group_id as $val) {
                $criteria = new criteria();
                $criteria->add('user_id', $user_id)->add('group_id', $val);
                $group = $this->searchOneByCriteria($criteria);
                if ($group) {
                    $this->delete($group->getId());
                }
            }
        } else {
            $criteria = new criteria();
            $criteria->add('user_id', $user_id)->add('group_id', $group_id);
            $group = $this->searchOneByCriteria($criteria);
            $this->delete($group->getId());
        }
    }

    /**
     * Метод, получающий список всех групп, с отметкой групп, в которых состоит пользователь
     *
     * @param integer $userId
     * @return array
     */
    public function searchAllByUserId($userId)
    {
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();

        $groupMapper = $toolkit->getMapper('user', 'group', $request->getSection());
        $table = $groupMapper->getTable();
        $hasMany = $groupMapper->getHasMany();

        $relTable = $hasMany['user']['table'];
        $table_key = $hasMany['user']['field'];
        $foreign_key = $hasMany['user']['key'];

        $criteria = new criteria($table);
        $criteria->addSelectField($table . '.*');
        $criteria->addSelectField($relTable . '.group_id');
        $criteria->addSelectField($relTable . '.user_id');

        $criterion = new criterion($table . '.' . $table_key, $relTable . '.' . $foreign_key, criteria::EQUAL, true);
        $criterion2 = new criterion($relTable . '.user_id', $userId);
        $criterion->addAnd($criterion2);

        $criteria->addJoin($relTable, $criterion);

        $select = new simpleSelect($criteria);

        $db = DB::factory();
        $stmt = $db->query($select->toString());
        $data = $stmt->fetchAll();

        $selected = array();

        foreach ($data as $key => $val) {
            $data[$key]= $groupMapper->createItemFromRow($val);
            if (!empty($val['user_id'])) {
                $selected[$data[$key]->getId()] = 1;
            }
        }

        return array($data, $selected);
    }

    /**
     * Конструктор
     *
     * @param string $section секция
     * @param string $alias название соединения с бд
     */
    public function __construct($section, $alias = 'default')
    {
        parent::__construct($section, $alias);
        $this->table = $this->table . '_rel';
    }

    /**
     * @todo сделать
     *
     * @param unknown_type $args
     */
    public function convertArgsToId($args)
    {

    }
}

?>