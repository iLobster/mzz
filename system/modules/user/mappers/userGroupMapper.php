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

    /**
     * @todo сделать
     *
     * @param integer $args
     */
    public function convertArgsToId($args)
    {

    }
}

?>