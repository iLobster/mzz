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
 * commentsFolderMapper: маппер
 *
 * @package modules
 * @subpackage comments
 * @version 0.1
 */

fileLoader::load('comments/commentsFolder');

class commentsFolderMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'comments';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'commentsFolder';

    /**
     * Возвращает уникальный для ДО идентификатор исходя из аргументов запроса
     *
     * @return object
     */
    public function convertArgsToId($args)
    {
        $comment = $this->searchOneByField('parent_id', $args['parent_id']);
        return $comment->getObjId();
    }
}

?>