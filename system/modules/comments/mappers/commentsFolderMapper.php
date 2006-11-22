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
     * Удаление папки вместе с содержимым на основе id
     *
     * @param string $id
     * @return void
     */
    public function remove($id)
    {
        $toolkit = systemToolkit::getInstance();

        $commentsMapper = $toolkit->getMapper('comments', 'comments', 'comments');

        foreach ($commentsMapper->searchAllByField('folder_id', $id) as $comment) {
            $commentsMapper->delete($comment->getId());
        }

        $this->delete($id);
    }

    /**
     * Возвращает уникальный для ДО идентификатор исходя из аргументов запроса
     *
     * @return object
     */
    public function convertArgsToId($args)
    {
        if (isset($args['parent_id']) || isset($args['id'])) {
            $parent_id = isset($args['parent_id']) ? $args['parent_id'] : $args['id'];
        } else {
            return 1;
        }

        $comment = $this->searchOneByField('parent_id', $parent_id);

        if (is_null($comment)) {
            $toolkit = systemToolkit::getInstance();
            $request = $toolkit->getRequest();
            $ownerId = $request->get('owner', 'string', SC_PATH);
            $userMapper = $toolkit->getMapper('user', 'user', 'user');
            $owner = $userMapper->searchById($ownerId);

            $comment = $this->create();
            $comment->setParentId($parent_id);
            $this->save($comment, $owner);
        }

        return $comment->getObjId();
    }
}

?>