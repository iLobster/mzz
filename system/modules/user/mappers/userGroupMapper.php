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
 * groupMapper: маппер для групп пользователей
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */
class userGroupMapper extends mapper
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

    /**
     * Конструктор
     *
     * @param string $section секция
     */
    public function __construct($section)
    {
        parent::__construct($section);
        $this->table = $this->table . '_rel';
    }

    public function searchGroupsIdsByUser($user)
    {
        $criteria = new criteria();
        $criteria->setTable($this->table, $this->className);
        $criteria->add('user_id', (int)$user);
        $criteria->clearSelectFields()->addSelectField('group_id');
        $select = new $this->simpleSelectName($criteria);
        $stmt = $this->db->query($select->toString());
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    /**
     *
     * @param integer $args
     */
    public function convertArgsToObj($args)
    {

    }
}

?>